<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Error\Factory\ErrorFactoryInterface;
use Ellinaut\ElliRPC\Error\Translator\ErrorTranslatorInterface;
use Ellinaut\ElliRPC\Exception\ProcedureValidationException;
use Ellinaut\ElliRPC\Procedure\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\Procedure\Transaction\TransactionManagerInterface;
use Ellinaut\ElliRPC\Procedure\Validator\ProcedureValidatorInterface;
use Ellinaut\ElliRPC\Value\BulkProcedureResult;
use Ellinaut\ElliRPC\Value\JsonSerializableArray;
use Ellinaut\ElliRPC\Value\ProcedureResult;
use Ellinaut\ElliRPC\Value\RemoteProcedure;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use RuntimeException;
use Throwable;

/**
 * @author Philipp Marien
 */
class RPCHandler extends AbstractHttpHandler
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        ErrorFactoryInterface $errorFactory,
        ErrorTranslatorInterface $errorTranslator,
        protected readonly ProcedureValidatorInterface $procedureValidator,
        protected readonly ProcedureProcessorInterface $processor,
        protected readonly TransactionManagerInterface $transactionManager
    ) {
        parent::__construct($streamFactory, $responseFactory, $errorFactory, $errorTranslator);
    }

    /**
     * @param array $procedure
     * @return RemoteProcedure
     * @throws ProcedureValidationException
     */
    protected function createProcedureFromArray(array $procedure): RemoteProcedure
    {
        if (!array_key_exists('package', $procedure) || !is_string($procedure['package'])) {
            throw new ProcedureValidationException(
                'Required property "package" is missing or invalid.'
            );
        }

        if (!array_key_exists('procedure', $procedure) || !is_string($procedure['procedure'])) {
            throw new ProcedureValidationException(
                'Required property "procedure" is missing or invalid.'
            );
        }

        if (!array_key_exists('data', $procedure) || (!is_array($procedure['data']) && !is_null($procedure['data']))) {
            throw new ProcedureValidationException(
                'Required property "data" is missing or invalid.'
            );
        }
        $this->procedureValidator->validateData($procedure['package'], $procedure['procedure'], $procedure['data']);

        if (!array_key_exists('meta', $procedure) || (!is_array($procedure['meta']) && !is_null($procedure['meta']))) {
            throw new ProcedureValidationException(
                'Required property "meta" is missing or invalid.'
            );
        }
        $this->procedureValidator->validateMeta($procedure['package'], $procedure['procedure'], $procedure['meta']);

        return new RemoteProcedure(
            $procedure['package'],
            $procedure['procedure'],
            $procedure['data'],
            $procedure['meta']
        );
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws ProcedureValidationException
     * @throws Throwable
     */
    protected function createProceduresFromRequest(RequestInterface $request): array
    {
        $bulkRequest = $this->getDecodedJsonRequestBody($request);
        if (!array_key_exists('procedures', $bulkRequest) || !is_array($bulkRequest['procedures'])) {
            throw new ProcedureValidationException('Required property "procedures" is invalid or missing.');
        }

        $procedures = [];
        foreach ($bulkRequest['procedures'] as $procedure) {
            $procedures[] = $this->createProcedureFromArray($procedure);
        }

        return $procedures;
    }

    /**
     * @param RemoteProcedure[] $procedures
     * @param bool $abortOnError
     * @return BulkProcedureResult[]
     */
    protected function executeProcedures(array $procedures, bool $abortOnError): array
    {
        $results = [];
        $aborted = false;
        foreach ($procedures as $procedure) {
            if ($aborted) {
                $results[] = new BulkProcedureResult(
                    $procedure,
                    new ProcedureResult(false, null, null, [
                        $this->createErrorFromThrowable(
                            new RuntimeException(
                                'Procedure could not be executed because previous procedure has failed.'
                            )
                        )
                    ])
                );

                continue;
            }

            try {
                $result = new BulkProcedureResult(
                    $procedure,
                    $this->processor->process($procedure)
                );
            } catch (Throwable $throwable) {
                $result = new BulkProcedureResult(
                    $procedure,
                    new ProcedureResult(false, null, null, [$this->createErrorFromThrowable($throwable)])
                );

                if ($abortOnError) {
                    $aborted = true;
                    $this->transactionManager->cancelTransaction();
                }
            }
            $results[] = $result;
        }

        return $results;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeExecuteProcedure(RequestInterface $request): ResponseInterface
    {
        try {
            $procedureRequest = $this->getDecodedJsonRequestBody($request);
            $procedure = $this->createProcedureFromArray($procedureRequest);

            return $this->createJsonResponse(
                $this->processor->process($procedure)
            );
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeExecuteBulk(RequestInterface $request): ResponseInterface
    {
        try {
            $procedures = $this->createProceduresFromRequest($request);

            return $this->createJsonResponse(
                new JsonSerializableArray([
                    'procedures' => $this->executeProcedures($procedures, false)
                ])
            );
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeExecuteTransaction(RequestInterface $request): ResponseInterface
    {
        try {
            $procedures = $this->createProceduresFromRequest($request);

            $this->transactionManager->startTransaction();

            $results = $this->executeProcedures($procedures, true);

            if (!$this->transactionManager->isTransactionCanceled()) {
                try {
                    $this->transactionManager->commitTransaction();
                } catch (Throwable $throwable) {
                    $this->transactionManager->rollbackTransaction();

                    throw $throwable;
                }
            }

            return $this->createJsonResponse(
                new JsonSerializableArray([
                    'procedures' => $results
                ])
            );
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }
}

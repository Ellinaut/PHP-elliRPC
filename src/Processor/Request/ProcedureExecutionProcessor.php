<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ProcedureResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureResponse;
use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;
use Ellinaut\ElliRPC\DataTransfer\Workflow\TransactionResult;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\Exception\InvalidContentTypeHeaderException;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\ProcedureExecutionRequest;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionProcessor extends AbstractExecutionProcessor
{
    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if (!$request instanceof ProcedureExecutionRequest) {
            throw new InvalidRequestProcessorException();
        }

        $responseContext = new ProcedureResponseContext(
            $request->getRequestedContentType(),
            $request->getPackageName(),
            $request->getProcedureName()
        );

        $this->throwExceptionOnUnsupportedResponseFormat($responseContext);

        $transactionId = $this->generateTransactionId();
        $this->startTransaction($transactionId);

        $procedure = new Procedure(
            $request->getPackageName(),
            $request->getProcedureName(),
            $this->parseProcedureDataFromRequest($request),
            $request->getQuery()['pagination'] ?? [],
            $request->getQuery()['sort'] ?? null
        );

        try {
            $procedureResult = $this->executeProcedure($transactionId, $procedure);
        } catch (Throwable $exception) {
            $procedureResult = new ProcedureResult($procedure, null, $exception);
        }

        $this->finishTransaction(new TransactionResult($transactionId, [$procedureResult]));

        return $this->createResponse(
            new ProcedureResponse(
                $responseContext,
                $procedureResult
            )
        );
    }

    /**
     * @param ProcedureExecutionRequest $request
     * @return array
     * @throws Throwable
     */
    protected function parseProcedureDataFromRequest(ProcedureExecutionRequest $request): array
    {
        if (!$request->getBody()) {
            return $query['data'] ?? [];
        }

        $contentTypeHeader = $request->getHeaderValue('Content-Type');
        if (empty($contentTypeHeader)) {
            throw new InvalidContentTypeHeaderException();
        }

        switch ($contentTypeHeader) {
            case 'application/json':
                return json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);
            case 'application/x-www-form-urlencoded':
                $parsedData = [];
                parse_str($request->getBody(), $parsedData);
                return $parsedData;
            case'multipart/form-data':
                //@todo
                return [];
        }

        throw new InvalidContentTypeHeaderException();
    }

    /**
     * @return string
     */
    protected function generateTransactionId(): string
    {
        return sha1(uniqid('transaction', true));
    }
}

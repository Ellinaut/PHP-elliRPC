<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Transaction;
use Ellinaut\ElliRPC\Exception\MissingContentTypeException;
use Ellinaut\ElliRPC\Exception\UnsupportedContentTypeException;
use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\ProcedureExecutionRequest;
use Ellinaut\ElliRPC\ResponseFactory\ProcedureExecutionResponseFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionProcessor implements RequestProcessorInterface
{
    use TransactionProcessorTrait;

    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var ProcedureProcessorInterface
     */
    private ProcedureProcessorInterface $procedureProcessor;

    /**
     * @var ProcedureExecutionResponseFactoryInterface
     */
    private ProcedureExecutionResponseFactoryInterface $responseFactory;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $procedureProcessor
     * @param ProcedureExecutionResponseFactoryInterface $responseFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        ProcedureProcessorInterface $procedureProcessor,
        ProcedureExecutionResponseFactoryInterface $responseFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->procedureProcessor = $procedureProcessor;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if (!$request instanceof ProcedureExecutionRequest) {
            //@todo exception
            throw new \Exception();
        }

        //@todo check content type extension for response and accept header matching the content type extension

        $procedureResult = $this->executeTransaction(
            $this->eventDispatcher,
            $this->procedureProcessor,
            new Transaction(
                'ID', //@todo
                [
                    new Procedure(
                        'ID',//@todo
                        $request->getPackageName(),
                        $request->getProcedureName(),
                        $this->parseProcedureDataFromRequest($request),
                        $request->getQuery()['pagination'] ?? [],
                        $request->getQuery()['sort'] ?? null
                    )
                ]
            )
        )->getProcedureResults()[0];

        return $this->responseFactory->createResponse($request, $procedureResult);
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
            throw new MissingContentTypeException();
        }

        $parsedData = [];
        switch ($contentTypeHeader) {
            case 'application/json':
            case 'application/ld+json':
                $parsedData = json_decode($request->getBody(), true, 512, JSON_THROW_ON_ERROR);
                break;
            case 'application/x-www-form-urlencoded':
                parse_str($request->getBody(), $parsedData);
                break;
            case'multipart/form-data':
                //@todo
                break;
            default:
                throw new UnsupportedContentTypeException($contentTypeHeader);
        }

        return $parsedData;
    }
}

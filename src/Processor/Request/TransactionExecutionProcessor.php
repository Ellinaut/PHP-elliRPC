<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Transaction;
use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\TransactionsExecutionRequest;
use Ellinaut\ElliRPC\ResponseFactory\AbstractResponseFactory;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class TransactionExecutionProcessor extends AbstractResponseFactory
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
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface $streamFactory
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $procedureProcessor
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        EventDispatcherInterface $eventDispatcher,
        ProcedureProcessorInterface $procedureProcessor
    ) {
        parent::__construct($responseFactory, $streamFactory);
        $this->eventDispatcher = $eventDispatcher;
        $this->procedureProcessor = $procedureProcessor;
    }

    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if (!$request instanceof TransactionsExecutionRequest) {
            //@todo exception
            throw new \Exception();
        }

        $transactionResults = [];
        foreach ($request->getTransactions() as $id => $procedures) {
            $procedureObjects = [];
            foreach ($procedures as $procedure) {
                $procedureObjects[] = new Procedure(
                    $procedure['procedureId'],
                    $procedure['package'],
                    $procedure['procedure'],
                    $procedure['data'],
                    $procedure['pagination'],
                    $procedure['sorting']
                );
            }

            $transactionResults[] = $this->executeTransaction(
                $this->eventDispatcher,
                $this->procedureProcessor,
                new Transaction($id, $procedureObjects)
            );
        }

        //@todo build response data
        return $this->createJsonResponse([]);
    }
}

<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;
use Ellinaut\ElliRPC\DataTransfer\Workflow\TransactionResult;
use Ellinaut\ElliRPC\Event\ProcedureExecutionFailed;
use Ellinaut\ElliRPC\Event\ProcedureExecutionFinished;
use Ellinaut\ElliRPC\Event\ProcedureExecutionStarted;
use Ellinaut\ElliRPC\Event\TransactionFinished;
use Ellinaut\ElliRPC\Event\TransactionStarted;
use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractExecutionProcessor extends AbstractRequestProcessor
{
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
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $procedureProcessor
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        EventDispatcherInterface $eventDispatcher,
        ProcedureProcessorInterface $procedureProcessor
    ) {
        parent::__construct($responseFactory);
        $this->eventDispatcher = $eventDispatcher;
        $this->procedureProcessor = $procedureProcessor;
    }

    protected function dispatch(object $event): void
    {
        $this->eventDispatcher->dispatch($event);
    }

    /**
     * @param string $id
     */
    protected function startTransaction(string $id): void
    {
        $this->dispatch(new TransactionStarted($id));
    }

    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return ProcedureResult
     */
    protected function executeProcedure(string $transactionId, Procedure $procedure): ProcedureResult
    {
        try {
            $this->dispatch(new ProcedureExecutionStarted($transactionId, $procedure));

            $procedureResult = $this->procedureProcessor->process($transactionId, $procedure);

            $this->dispatch(new ProcedureExecutionFinished($transactionId, $procedureResult));

            return $procedureResult;
        } catch (Throwable $exception) {
            $this->dispatch(new ProcedureExecutionFailed($transactionId, $procedure, $exception));

            return new ProcedureResult($procedure, null, $exception);
        }
    }

    /**
     * @param TransactionResult $transactionResult
     */
    protected function finishTransaction(TransactionResult $transactionResult): void
    {
        $this->dispatch(new TransactionFinished($transactionResult));
    }
}

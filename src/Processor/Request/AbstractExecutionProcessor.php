<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;
use Ellinaut\ElliRPC\Enum\ExecutionStatus;
use Ellinaut\ElliRPC\Event\ProcedureExecutionFailed;
use Ellinaut\ElliRPC\Event\ProcedureExecutionFinished;
use Ellinaut\ElliRPC\Event\ProcedureExecutionStarted;
use Ellinaut\ElliRPC\Event\TransactionFinished;
use Ellinaut\ElliRPC\Event\TransactionStarted;
use Ellinaut\ElliRPC\Processor\ProcedureExceptionProcessorInterface;
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
     * @var ProcedureExceptionProcessorInterface
     */
    private ProcedureExceptionProcessorInterface $procedureExceptionProcessor;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $procedureProcessor
     * @param ProcedureExceptionProcessorInterface $procedureExceptionProcessor
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        EventDispatcherInterface $eventDispatcher,
        ProcedureProcessorInterface $procedureProcessor,
        ProcedureExceptionProcessorInterface $procedureExceptionProcessor
    ) {
        parent::__construct($responseFactory);
        $this->eventDispatcher = $eventDispatcher;
        $this->procedureProcessor = $procedureProcessor;
        $this->procedureExceptionProcessor = $procedureExceptionProcessor;
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
        } catch (Throwable $exception) {
            $this->dispatch(new ProcedureExecutionFailed($transactionId, $procedure, $exception));

            $procedureResult = $this->procedureExceptionProcessor->process($transactionId, $procedure, $exception);
        }

        return $procedureResult;
    }

    /**
     * @param string $id
     * @param bool $successful
     */
    protected function finishTransaction(string $id, bool $successful): void
    {
        $this->dispatch(new TransactionFinished($id, $successful));
    }

    /**
     * @param ProcedureResult[] $procedureResults
     * @return bool
     */
    protected function isTransactionSuccessful(array $procedureResults): bool
    {
        foreach ($procedureResults as $procedureResult) {
            if (!ExecutionStatus::isSuccessful($procedureResult->getStatus())) {
                return false;
            }
        }

        return true;
    }
}

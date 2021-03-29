<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\Event\TransactionFailed;
use Ellinaut\ElliRPC\Event\TransactionFinished;
use Ellinaut\ElliRPC\Event\TransactionStarted;
use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @author Philipp Marien
 */
abstract class AbstractProcedureExecutionProcessor implements RequestProcessorInterface
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var ProcedureProcessorInterface
     */
    private ProcedureProcessorInterface $processor;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $processor
     */
    public function __construct(EventDispatcherInterface $eventDispatcher, ProcedureProcessorInterface $processor)
    {
        $this->eventDispatcher = $eventDispatcher;
        $this->processor = $processor;
    }

    /**
     * @return ProcedureProcessorInterface
     */
    protected function getProcessor(): ProcedureProcessorInterface
    {
        return $this->processor;
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
     * @param string $id
     */
    protected function finishTransaction(string $id): void
    {
        $this->dispatch(new TransactionFinished($id));
    }

    /**
     * @param string $id
     */
    protected function failTransaction(string $id): void
    {
        $this->dispatch(new TransactionFailed($id));
    }

    /**
     * @return string
     */
    protected function generateTransactionId(): string
    {
        return sha1(uniqid('transaction', true));
    }
}

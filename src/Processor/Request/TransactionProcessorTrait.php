<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Transaction;
use Ellinaut\ElliRPC\DataTransfer\TransactionResult;
use Ellinaut\ElliRPC\Enum\ExecutionStatus;
use Ellinaut\ElliRPC\Event\ProcedureExecutionFinished;
use Ellinaut\ElliRPC\Event\ProcedureExecutionStarted;
use Ellinaut\ElliRPC\Event\TransactionFinished;
use Ellinaut\ElliRPC\Event\TransactionStarted;
use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

/**
 * @author Philipp Marien
 */
trait TransactionProcessorTrait
{
    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param ProcedureProcessorInterface $procedureProcessor
     * @param Transaction $transaction
     * @return TransactionResult
     */
    protected function executeTransaction(
        EventDispatcherInterface $eventDispatcher,
        ProcedureProcessorInterface $procedureProcessor,
        Transaction $transaction
    ): TransactionResult {
        $eventDispatcher->dispatch(new TransactionStarted($transaction));

        $procedureResults = [];
        $transactionStatus = ExecutionStatus::EXECUTED;
        foreach ($transaction->getProcedures() as $procedure) {
            $eventDispatcher->dispatch(new ProcedureExecutionStarted($procedure));
            $procedureResult = $procedureProcessor->process($procedure);
            $eventDispatcher->dispatch(new ProcedureExecutionFinished($procedureResult));

            if ($procedureResult->getStatus() === ExecutionStatus::FAILED) {
                $transactionStatus = ExecutionStatus::FAILED;
            }

            $procedureResults[] = $procedureResult;
        }

        $transactionResult = new TransactionResult($transaction, $procedureResults, $transactionStatus);

        $eventDispatcher->dispatch(new TransactionFinished($transactionResult));

        return $transactionResult;
    }
}

<?php

namespace Ellinaut\ElliRPC\DataTransfer;

/**
 * @author Philipp Marien
 */
class TransactionResult
{
    /**
     * @var Transaction
     */
    private Transaction $transaction;

    /**
     * @var ProcedureResult[]
     */
    private array $procedureResults;

    /**
     * @var string
     */
    private string $executionStatus;

    /**
     * @param Transaction $transaction
     * @param ProcedureResult[] $procedureResults
     * @param string $executionStatus
     */
    public function __construct(Transaction $transaction, array $procedureResults, string $executionStatus)
    {
        $this->transaction = $transaction;
        $this->procedureResults = $procedureResults;
        $this->executionStatus = $executionStatus;
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @return ProcedureResult[]
     */
    public function getProcedureResults(): array
    {
        return $this->procedureResults;
    }

    /**
     * @return string
     */
    public function getExecutionStatus(): string
    {
        return $this->executionStatus;
    }
}

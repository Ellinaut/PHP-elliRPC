<?php

namespace Ellinaut\ElliRPC\Server\Value;

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
     * @param Transaction $transaction
     * @param ProcedureResult[] $procedureResults
     */
    public function __construct(Transaction $transaction, array $procedureResults)
    {
        $this->transaction = $transaction;
        $this->procedureResults = $procedureResults;
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
}

<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

/**
 * @author Philipp Marien
 */
class TransactionResult
{
    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @var ProcedureResult[]
     */
    private array $procedureResults;

    /**
     * @param string $transactionId
     * @param ProcedureResult[] $procedureResults
     */
    public function __construct(string $transactionId, array $procedureResults)
    {
        $this->transactionId = $transactionId;
        $this->procedureResults = $procedureResults;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return ProcedureResult[]
     */
    public function getProcedureResults(): array
    {
        return $this->procedureResults;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        foreach ($this->getProcedureResults() as $procedureResult) {
            if (!$procedureResult->isSuccessful()) {
                return false;
            }
        }

        return true;
    }
}

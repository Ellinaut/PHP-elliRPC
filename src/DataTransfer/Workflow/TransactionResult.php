<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

use Throwable;

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
     * @var Throwable|null
     */
    private ?Throwable $exception;

    /**
     * @param string $transactionId
     * @param ProcedureResult[] $procedureResults
     * @param Throwable|null $exception
     */
    public function __construct(string $transactionId, array $procedureResults, ?Throwable $exception)
    {
        $this->transactionId = $transactionId;
        $this->procedureResults = $procedureResults;
        $this->exception = $exception;
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

        return $this->getException() !== null;
    }

    /**
     * @return Throwable|null
     */
    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}

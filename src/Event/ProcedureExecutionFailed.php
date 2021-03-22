<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionFailed
{
    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @var Procedure
     */
    private Procedure $procedure;

    /**
     * @var Throwable
     */
    private Throwable $exception;

    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @param Throwable $exception
     */
    public function __construct(string $transactionId, Procedure $procedure, Throwable $exception)
    {
        $this->transactionId = $transactionId;
        $this->procedure = $procedure;
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
     * @return Procedure
     */
    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }

    /**
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }
}

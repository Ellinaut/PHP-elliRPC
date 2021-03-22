<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionStarted
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
     * @param string $transactionId
     * @param Procedure $procedure
     */
    public function __construct(string $transactionId, Procedure $procedure)
    {
        $this->transactionId = $transactionId;
        $this->procedure = $procedure;
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
}

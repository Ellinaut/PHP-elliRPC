<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionFinished
{
    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @var ProcedureResult
     */
    private ProcedureResult $procedureResult;

    /**
     * @param string $transactionId
     * @param ProcedureResult $procedureResult
     */
    public function __construct(string $transactionId, ProcedureResult $procedureResult)
    {
        $this->transactionId = $transactionId;
        $this->procedureResult = $procedureResult;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return ProcedureResult
     */
    public function getProcedureResult(): ProcedureResult
    {
        return $this->procedureResult;
    }
}

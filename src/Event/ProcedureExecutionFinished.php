<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\ProcedureResult;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionFinished
{
    /**
     * @var ProcedureResult
     */
    private ProcedureResult $procedureResult;

    /**
     * @param ProcedureResult $procedureResult
     */
    public function __construct(ProcedureResult $procedureResult)
    {
        $this->procedureResult = $procedureResult;
    }

    /**
     * @return ProcedureResult
     */
    public function getProcedureResult(): ProcedureResult
    {
        return $this->procedureResult;
    }
}

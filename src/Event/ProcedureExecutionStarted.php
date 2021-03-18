<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Procedure;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionStarted
{
    /**
     * @var Procedure
     */
    private Procedure $procedure;

    /**
     * @param Procedure $procedure
     */
    public function __construct(Procedure $procedure)
    {
        $this->procedure = $procedure;
    }

    /**
     * @return Procedure
     */
    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }
}

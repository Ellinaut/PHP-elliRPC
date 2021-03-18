<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionFailed
{
    /**
     * @var Procedure
     */
    private Procedure $procedure;

    /**
     * @var Throwable
     */
    private Throwable $throwable;

    /**
     * @param Procedure $procedure
     * @param Throwable $throwable
     */
    public function __construct(Procedure $procedure, Throwable $throwable)
    {
        $this->procedure = $procedure;
        $this->throwable = $throwable;
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
    public function getThrowable(): Throwable
    {
        return $this->throwable;
    }
}

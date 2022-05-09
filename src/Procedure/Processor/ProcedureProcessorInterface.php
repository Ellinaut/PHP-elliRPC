<?php

namespace Ellinaut\ElliRPC\Procedure\Processor;

use Ellinaut\ElliRPC\Value\ProcedureResult;
use Ellinaut\ElliRPC\Value\RemoteProcedure;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param RemoteProcedure $procedure
     * @return ProcedureResult
     */
    public function process(RemoteProcedure $procedure): ProcedureResult;
}

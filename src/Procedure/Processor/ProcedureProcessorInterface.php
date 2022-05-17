<?php

namespace Ellinaut\ElliRPC\Procedure\Processor;

use Ellinaut\ElliRPC\Procedure\ExecutionContext;
use Ellinaut\ElliRPC\Value\ProcedureResult;
use Ellinaut\ElliRPC\Value\RemoteProcedure;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param RemoteProcedure $procedure
     * @param ExecutionContext $context
     * @return ProcedureResult
     */
    public function process(RemoteProcedure $procedure, ExecutionContext $context): ProcedureResult;
}

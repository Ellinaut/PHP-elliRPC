<?php

namespace Ellinaut\ElliRPC\Server\Processor;

use Ellinaut\ElliRPC\Server\Value\Procedure;
use Ellinaut\ElliRPC\Server\Value\ProcedureResult;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param Procedure $procedure
     * @return ProcedureResult
     */
    public function execute(Procedure $procedure): ProcedureResult;
}

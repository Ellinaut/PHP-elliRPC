<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\ProcedureResult;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param Procedure $procedure
     * @return ProcedureResult
     */
    public function process(Procedure $procedure): ProcedureResult;
}

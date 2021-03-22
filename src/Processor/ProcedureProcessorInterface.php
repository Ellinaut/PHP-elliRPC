<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return ProcedureResult
     */
    public function process(string $transactionId, Procedure $procedure): ProcedureResult;
}

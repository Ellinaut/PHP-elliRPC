<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\ProcedureBody;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return ProcedureBody
     */
    public function process(string $transactionId, Procedure $procedure): ProcedureBody;
}

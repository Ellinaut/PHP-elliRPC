<?php

namespace Ellinaut\ElliRPC\Procedure;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\ProcedureBody;

/**
 * @author Philipp Marien
 */
interface ProcessorInterface
{
    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return ProcedureBody
     */
    public function process(string $transactionId, Procedure $procedure): ProcedureBody;
}

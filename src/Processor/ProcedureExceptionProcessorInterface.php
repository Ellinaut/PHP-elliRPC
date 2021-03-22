<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;
use Throwable;

/**
 * @author Philipp Marien
 */
interface ProcedureExceptionProcessorInterface
{
    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @param Throwable $exception
     * @return ProcedureResult
     */
    public function process(string $transactionId, Procedure $procedure, Throwable $exception): ProcedureResult;
}

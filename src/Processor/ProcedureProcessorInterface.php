<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\Value\ProcedureInterface;
use Ellinaut\ElliRPC\Value\ProcedureResultInterface;

/**
 * @author Philipp Marien
 */
interface ProcedureProcessorInterface
{
    /**
     * @param ProcedureInterface $procedure
     * @return ProcedureResultInterface
     */
    public function process(ProcedureInterface $procedure): ProcedureResultInterface;
}

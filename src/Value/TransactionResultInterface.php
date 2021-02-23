<?php

namespace Ellinaut\ElliRPC\Value;

use Ellinaut\ElliRPC\Enum\ExecutionStatus;

/**
 * @author Philipp Marien
 */
interface TransactionResultInterface
{
    /**
     * @return string
     */
    public function getTransactionId(): string;

    /**
     * @return ProcedureResultInterface[]
     */
    public function getProcedureResults(): array;

    /**
     * @return string
     * @see ExecutionStatus
     */
    public function getStatus(): string;
}

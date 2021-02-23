<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
interface TransactionInterface
{
    /**
     * @return string
     */
    public function getTransactionId(): string;

    /**
     * @return ProcedureInterface[]
     */
    public function getProcedures(): array;
}

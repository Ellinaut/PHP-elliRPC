<?php

namespace Ellinaut\ElliRPC\Procedure;

use Ellinaut\ElliRPC\DataTransfer\Procedure;

/**
 * @author Philipp Marien
 */
interface ProcessorInterface
{
    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return array|null
     */
    public function process(string $transactionId, Procedure $procedure): ?array;
}

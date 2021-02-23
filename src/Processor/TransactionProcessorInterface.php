<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\Value\TransactionInterface;
use Ellinaut\ElliRPC\Value\TransactionResultInterface;

/**
 * @author Philipp Marien
 */
interface TransactionProcessorInterface
{
    /**
     * @param string $packageName
     * @param string $procedureName
     * @param ProcedureProcessorInterface $processor
     */
    public function register(string $packageName, string $procedureName, ProcedureProcessorInterface $processor): void;

    /**
     * @param TransactionInterface $transaction
     * @return TransactionResultInterface
     */
    public function process(TransactionInterface $transaction): TransactionResultInterface;
}

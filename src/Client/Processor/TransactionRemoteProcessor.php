<?php

namespace Ellinaut\ElliRPC\Client\Processor;

use Ellinaut\ElliRPC\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\Processor\TransactionProcessorInterface;
use Ellinaut\ElliRPC\Value\TransactionInterface;
use Ellinaut\ElliRPC\Value\TransactionResultInterface;

/**
 * @author Philipp Marien
 */
class TransactionRemoteProcessor implements TransactionProcessorInterface
{
    /**
     * @var array
     */
    private array $packageProcedures = [];

    /**
     * @param string $packageName
     * @param string $procedureName
     * @param ProcedureProcessorInterface $processor
     */
    public function register(string $packageName, string $procedureName, ProcedureProcessorInterface $processor): void
    {
        // TODO: Implement register() method.
    }

    /**
     * @param TransactionInterface $transaction
     * @return TransactionResultInterface
     */
    public function process(TransactionInterface $transaction): TransactionResultInterface
    {
        // TODO: Implement process() method.
    }
}

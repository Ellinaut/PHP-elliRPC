<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\TransactionResult;

/**
 * @author Philipp Marien
 */
class TransactionFinished
{
    /**
     * @var TransactionResult
     */
    private TransactionResult $transactionResult;

    /**
     * @param TransactionResult $transactionResult
     */
    public function __construct(TransactionResult $transactionResult)
    {
        $this->transactionResult = $transactionResult;
    }

    /**
     * @return TransactionResult
     */
    public function getTransactionResult(): TransactionResult
    {
        return $this->transactionResult;
    }
}

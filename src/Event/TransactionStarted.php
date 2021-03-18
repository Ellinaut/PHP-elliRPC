<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Transaction;

/**
 * @author Philipp Marien
 */
class TransactionStarted
{
    /**
     * @var Transaction
     */
    private Transaction $transaction;

    /**
     * @param Transaction $transaction
     */
    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @return Transaction
     */
    public function getTransaction(): Transaction
    {
        return $this->transaction;
    }
}

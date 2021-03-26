<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\DataTransfer\Workflow\TransactionResult;

/**
 * @author Philipp Marien
 */
class TransactionFinished extends AbstractTransactionEvent
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
        parent::__construct($transactionResult->getTransactionId());
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

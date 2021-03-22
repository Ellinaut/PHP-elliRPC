<?php

namespace Ellinaut\ElliRPC\Event;

/**
 * @author Philipp Marien
 */
class TransactionFinished extends AbstractTransactionEvent
{
    /**
     * @var bool
     */
    private bool $successful;

    /**
     * @param string $transactionId
     * @param bool $successful
     */
    public function __construct(string $transactionId, bool $successful)
    {
        parent::__construct($transactionId);
        $this->successful = $successful;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->successful;
    }
}

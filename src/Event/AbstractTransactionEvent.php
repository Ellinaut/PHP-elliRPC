<?php

namespace Ellinaut\ElliRPC\Event;

/**
 * @author Philipp Marien
 */
class AbstractTransactionEvent
{
    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @param string $transactionId
     */
    public function __construct(string $transactionId)
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }
}

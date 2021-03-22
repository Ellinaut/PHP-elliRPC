<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

/**
 * @author Philipp Marien
 */
class TransactionsExecutionRequest extends AbstractRequest
{
    /**
     * @var array[]
     */
    private array $transactions;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param array[] $transactions
     */
    public function __construct(array $headers, string $requestedContentType, array $transactions)
    {
        parent::__construct($headers, $requestedContentType);
        $this->transactions = $transactions;
    }

    /**
     * @return array[]
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }
}

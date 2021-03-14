<?php

namespace Ellinaut\ElliRPC\Server\Value;

/**
 * @author Philipp Marien
 */
class Transaction
{
    /**
     * @var string
     */
    private string $transactionId;

    /**
     * @var Procedure[]
     */
    private array $procedures;

    /**
     * @param string $transactionId
     * @param Procedure[] $procedures
     */
    public function __construct(string $transactionId, array $procedures)
    {
        $this->transactionId = $transactionId;
        $this->procedures = $procedures;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @return Procedure[]
     */
    public function getProcedures(): array
    {
        return $this->procedures;
    }
}

<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Workflow\TransactionResult;

/**
 * @author Philipp Marien
 */
class TransactionsResponse extends AbstractFormatableResponse
{
    /**
     * @var TransactionResult[]
     */
    private array $content;

    /**
     * @param AbstractResponseContext $context
     * @param TransactionResult[] $content
     */
    public function __construct(AbstractResponseContext $context, array $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return TransactionResult[]
     */
    public function getContent(): array
    {
        return $this->content;
    }
}

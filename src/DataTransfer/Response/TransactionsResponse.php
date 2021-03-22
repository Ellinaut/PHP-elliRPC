<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;

/**
 * @author Philipp Marien
 */
class TransactionsResponse extends AbstractFormatableResponse
{
    /**
     * @var ProcedureResult[]
     */
    private array $content;

    /**
     * @param ResponseContext $context
     * @param ProcedureResult[] $content
     */
    public function __construct(ResponseContext $context, array $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return ProcedureResult[]
     */
    public function getContent(): array
    {
        return $this->content;
    }
}

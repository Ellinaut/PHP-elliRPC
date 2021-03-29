<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\ExecutionResult;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionBulkResponse extends AbstractFormatableResponse
{
    /**
     * @var ExecutionResult[]
     */
    private array $content;

    /**
     * @param AbstractFormattingContext $context
     * @param ExecutionResult[] $content
     */
    public function __construct(AbstractFormattingContext $context, array $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return ExecutionResult[]
     */
    public function getContent(): array
    {
        return $this->content;
    }
}

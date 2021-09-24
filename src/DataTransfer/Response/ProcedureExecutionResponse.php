<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionResponse extends AbstractFormatableResponse
{
    /**
     * @var array|null
     */
    private ?array $content;

    /**
     * @param AbstractFormattingContext $context
     * @param array|null $content
     */
    public function __construct(AbstractFormattingContext $context, ?array $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return array|null
     */
    public function getContent(): ?array
    {
        return $this->content;
    }
}

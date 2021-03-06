<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionResponse extends AbstractFormatableResponse
{
    /**
     * @var SchemaDefinitionInterface
     */
    private SchemaDefinitionInterface $content;

    /**
     * @param AbstractFormattingContext $context
     * @param SchemaDefinitionInterface $content
     */
    public function __construct(AbstractFormattingContext $context, SchemaDefinitionInterface $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return SchemaDefinitionInterface
     */
    public function getContent(): SchemaDefinitionInterface
    {
        return $this->content;
    }
}

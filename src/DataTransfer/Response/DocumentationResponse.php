<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;

/**
 * @author Philipp Marien
 */
class DocumentationResponse extends AbstractFormatableResponse
{
    /**
     * @var ApplicationDefinitionInterface
     */
    private ApplicationDefinitionInterface $content;

    /**
     * @param AbstractFormattingContext $context
     * @param ApplicationDefinitionInterface $content
     */
    public function __construct(AbstractFormattingContext $context, ApplicationDefinitionInterface $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return ApplicationDefinitionInterface
     */
    public function getContent(): ApplicationDefinitionInterface
    {
        return $this->content;
    }
}

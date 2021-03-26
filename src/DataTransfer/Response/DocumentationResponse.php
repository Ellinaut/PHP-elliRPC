<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
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
     * @param AbstractResponseContext $context
     * @param ApplicationDefinitionInterface $content
     */
    public function __construct(AbstractResponseContext $context, ApplicationDefinitionInterface $content)
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

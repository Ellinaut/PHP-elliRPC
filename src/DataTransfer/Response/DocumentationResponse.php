<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
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
     * @param ResponseContext $context
     * @param ApplicationDefinitionInterface $content
     */
    public function __construct(ResponseContext $context, ApplicationDefinitionInterface $content)
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

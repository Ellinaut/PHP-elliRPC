<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
class PackageDefinitionsResponse extends AbstractFormatableResponse
{
    /**
     * @var PackageDefinitionInterface[]
     */
    private array $content;

    /**
     * @param AbstractResponseContext $context
     * @param PackageDefinitionInterface[] $content
     */
    public function __construct(AbstractResponseContext $context, array $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getContent(): array
    {
        return $this->content;
    }
}

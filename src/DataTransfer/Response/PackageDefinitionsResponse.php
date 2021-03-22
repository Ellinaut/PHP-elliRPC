<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
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
     * @param ResponseContext $context
     * @param PackageDefinitionInterface[] $content
     */
    public function __construct(ResponseContext $context, array $content)
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

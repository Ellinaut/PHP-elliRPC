<?php

namespace Ellinaut\ElliRPC\DataTransfer\FormattingContext;

/**
 * @author Philipp Marien
 */
class DefinitionContext extends AbstractFormattingContext
{
    public const ENDPOINT_DOCUMENTATION = 'documentation';

    public const ENDPOINT_PACKAGES = 'packages';

    public const ENDPOINT_SCHEMA = 'schema';

    /**
     * @var string
     */
    private string $definitionEndpoint;

    /**
     * @param string $contentTypeExtension
     * @param string[] $acceptedHeader
     * @param string $definitionEndpoint
     */
    public function __construct(string $contentTypeExtension, array $acceptedHeader, string $definitionEndpoint)
    {
        parent::__construct($contentTypeExtension, $acceptedHeader);
        $this->definitionEndpoint = $definitionEndpoint;
    }

    /**
     * @return string
     */
    public function getDefinitionEndpoint(): string
    {
        return $this->definitionEndpoint;
    }
}

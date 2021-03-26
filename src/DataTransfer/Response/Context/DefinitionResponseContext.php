<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response\Context;

/**
 * @author Philipp Marien
 */
class DefinitionResponseContext extends AbstractResponseContext
{
    public const ENDPOINT_DOCUMENTATION = 'documentation';

    public const ENDPOINT_PACKAGES = 'packages';

    public const ENDPOINT_SCHEMA = 'schema';

    /**
     * @var string
     */
    private string $definitionEndpoint;

    /**
     * @param string $contentType
     * @param string $definitionEndpoint
     */
    public function __construct(string $contentType, string $definitionEndpoint)
    {
        parent::__construct($contentType);

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

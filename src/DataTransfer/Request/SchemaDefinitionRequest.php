<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private string $schemaName;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param string $schemaName
     */
    public function __construct(array $headers, string $requestedContentType, string $schemaName)
    {
        parent::__construct($headers, $requestedContentType);
        $this->schemaName = $schemaName;
    }

    /**
     * @return string
     */
    public function getSchemaName(): string
    {
        return $this->schemaName;
    }
}

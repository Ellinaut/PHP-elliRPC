<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

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
     * @param AbstractFormattingContext $context
     * @param string $schemaName
     * @param string[][] $requestHeaders
     */
    public function __construct(AbstractFormattingContext $context, string $schemaName, array $requestHeaders = [])
    {
        parent::__construct($context, $requestHeaders);
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

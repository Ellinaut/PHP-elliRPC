<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class SchemaReferenceDefinition implements SchemaReferenceDefinitionInterface
{
    private ?string $context;

    private string $schema;

    /**
     * @param string|null $context
     * @param string $schema
     */
    public function __construct(?string $context, string $schema)
    {
        $this->context = $context;
        $this->schema = $schema;
    }


    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->schema;
    }
}

<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;

/**
 * @author Philipp Marien
 */
class SchemaReferenceDefinition extends AbstractArrayDefinition implements SchemaReferenceDefinitionInterface
{
    public static function validate(array $definition): void
    {
        self::validateStringOrNull($definition, 'context');

        self::validateString($definition, 'schema');
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->definition['context'] ?? null;
    }

    /**
     * @return string
     */
    public function getSchema(): string
    {
        return $this->definition['schema'];
    }

    public function jsonSerialize(): array
    {
        return [
            'context' => $this->getContext(),
            'schema' => $this->getSchema(),
        ];
    }
}

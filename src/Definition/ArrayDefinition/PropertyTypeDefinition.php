<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\PropertyTypeDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class PropertyTypeDefinition extends AbstractArrayDefinition implements PropertyTypeDefinitionInterface
{
    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateStringOrNull($definition, 'context');

        self::validateString($definition, 'type');

        self::validateListOfStrings($definition, 'options');
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->definition['context'];
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->definition['type'];
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->definition['options'];
    }

    public function jsonSerialize(): array
    {
        return [
            'context' => $this->getContext(),
            'type' => $this->getType(),
            'options' => $this->getOptions(),
        ];
    }
}

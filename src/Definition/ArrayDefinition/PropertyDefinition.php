<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PropertyTypeDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class PropertyDefinition extends AbstractArrayDefinition implements PropertyDefinitionInterface
{
    private ?PropertyTypeDefinitionInterface $propertyType;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateString($definition, 'name');

        self::validateStringOrNull($definition, 'description');

        self::validateDefinition($definition, 'type', [PropertyTypeDefinition::class, 'validate']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->definition['name'];
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->definition['description'];
    }

    /**
     * @return PropertyTypeDefinitionInterface
     * @throws DefinitionException
     */
    public function getTypeDefinition(): PropertyTypeDefinitionInterface
    {
        if (!$this->propertyType) {
            $this->propertyType = new PropertyTypeDefinition($this->definition['type']);
        }

        return $this->propertyType;
    }


    /**
     * @throws DefinitionException
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'type' => $this->getTypeDefinition(),
        ];
    }
}

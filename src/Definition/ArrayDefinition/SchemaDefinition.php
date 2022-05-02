<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class SchemaDefinition extends AbstractArrayDefinition implements SchemaDefinitionInterface
{
    private ?SchemaReferenceDefinitionInterface $extends;

    private ?array $properties;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateString($definition, 'name');

        self::validateBoolean($definition, 'abstract');

        self::validateDefinitionOrNull($definition, 'extends', [SchemaReferenceDefinition::class, 'validate']);

        self::validateStringOrNull($definition, 'description');

        self::validateDefinitionSet($definition, 'properties', [PropertyDefinition::class, 'validate']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->definition['name'];
    }

    /**
     * @return bool
     */
    public function getAbstract(): bool
    {
        return $this->definition['abstract'];
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     * @throws DefinitionException
     */
    public function getExtendsDefinition(): ?SchemaReferenceDefinitionInterface
    {
        if (!$this->extends && $this->definition['extends']) {
            $this->extends = new SchemaReferenceDefinition($this->definition['extends']);
        }

        return $this->extends;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->definition['description'];
    }

    /**
     * @return ProcedureDefinitionInterface[]
     * @throws DefinitionException
     */
    public function getPropertyDefinitions(): array
    {
        if (!$this->properties) {
            $this->properties = [];
            foreach ($this->definition['properties'] as $error) {
                $this->properties[] = new PropertyDefinition($error);
            }
        }

        return $this->properties;
    }
}

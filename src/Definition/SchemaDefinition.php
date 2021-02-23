<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class SchemaDefinition implements SchemaDefinitionInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var bool
     */
    private bool $abstract;

    /**
     * @var SchemaReferenceDefinitionInterface|null
     */
    private ?SchemaReferenceDefinitionInterface $extendsDefinition;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var PropertyDefinitionInterface[]
     */
    private array $propertyDefinitions;

    /**
     * @param string $name
     * @param bool $abstract
     * @param SchemaReferenceDefinitionInterface|null $extendsDefinition
     * @param string|null $description
     * @param PropertyDefinitionInterface[] $propertyDefinitions
     */
    public function __construct(
        string $name,
        bool $abstract,
        ?SchemaReferenceDefinitionInterface $extendsDefinition,
        ?string $description,
        array $propertyDefinitions
    ) {
        $this->name = $name;
        $this->abstract = $abstract;
        $this->extendsDefinition = $extendsDefinition;
        $this->description = $description;
        $this->propertyDefinitions = $propertyDefinitions;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function isAbstract(): bool
    {
        return $this->abstract;
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getExtendsDefinition(): ?SchemaReferenceDefinitionInterface
    {
        return $this->extendsDefinition;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return PropertyDefinitionInterface[]
     */
    public function getPropertyDefinitions(): array
    {
        return $this->propertyDefinitions;
    }
}

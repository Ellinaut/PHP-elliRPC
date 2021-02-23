<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class PropertyDefinition implements PropertyDefinitionInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var PropertyTypeDefinitionInterface
     */
    private PropertyTypeDefinitionInterface $propertyTypeDefinition;

    /**
     * @param string $name
     * @param string|null $description
     * @param PropertyTypeDefinitionInterface $propertyTypeDefinition
     */
    public function __construct(
        string $name,
        ?string $description,
        PropertyTypeDefinitionInterface $propertyTypeDefinition
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->propertyTypeDefinition = $propertyTypeDefinition;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return PropertyTypeDefinitionInterface
     */
    public function getPropertyTypeDefinition(): PropertyTypeDefinitionInterface
    {
        return $this->propertyTypeDefinition;
    }
}

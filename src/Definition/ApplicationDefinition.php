<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class ApplicationDefinition implements ApplicationDefinitionInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string[]
     */
    private array $contentTypes;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var PackageDefinitionInterface[]
     */
    private array $packages;

    /**
     * @var SchemaDefinitionInterface[]
     */
    private array $schemas;

    /**
     * @param string $name
     * @param string[] $contentTypes
     * @param string|null $description
     * @param PackageDefinitionInterface[] $packages
     * @param SchemaDefinitionInterface[] $schemas
     */
    public function __construct(
        string $name,
        array $contentTypes,
        ?string $description,
        array $packages,
        array $schemas
    ) {
        $this->name = $name;
        $this->contentTypes = $contentTypes;
        $this->description = $description;
        $this->packages = $packages;
        $this->schemas = $schemas;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string[]
     */
    public function getContentTypes(): array
    {
        return $this->contentTypes;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackages(): array
    {
        return $this->packages;
    }

    /**
     * @return SchemaDefinitionInterface[]
     */
    public function getSchemas(): array
    {
        return $this->schemas;
    }
}

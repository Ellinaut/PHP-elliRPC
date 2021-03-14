<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface ApplicationDefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string[]
     */
    public function getContentTypes(): array;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackages(): array;

    /**
     * @return SchemaDefinitionInterface[]
     */
    public function getSchemas(): array;
}

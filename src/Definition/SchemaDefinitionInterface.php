<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return bool
     */
    public function isAbstract(): bool;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getExtendsDefinition(): ?SchemaReferenceDefinitionInterface;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return PropertyDefinitionInterface[]
     */
    public function getPropertyDefinitions(): array;
}

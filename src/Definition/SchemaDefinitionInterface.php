<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionInterface extends DefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return bool
     */
    public function getAbstract(): bool;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getExtendsDefinition(): ?SchemaReferenceDefinitionInterface;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return ProcedureDefinitionInterface[]
     */
    public function getPropertyDefinitions(): array;
}

<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface DataDefinitionInterface extends DefinitionInterface
{
    /**
     * @return string|null
     */
    public function getContext(): ?string;

    /**
     * @return string
     */
    public function getSchema(): string;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getWrappedByDefinition(): ?SchemaReferenceDefinitionInterface;

    /**
     * @return bool
     */
    public function isNullable(): bool;
}

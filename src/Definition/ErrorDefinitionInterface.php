<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface ErrorDefinitionInterface extends DefinitionInterface
{
    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getContext(): ?SchemaReferenceDefinitionInterface;
}

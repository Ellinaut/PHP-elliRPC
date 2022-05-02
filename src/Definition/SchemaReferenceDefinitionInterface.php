<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface SchemaReferenceDefinitionInterface extends DefinitionInterface
{
    /**
     * @return string|null
     */
    public function getContext(): ?string;

    /**
     * @return string
     */
    public function getSchema(): string;
}

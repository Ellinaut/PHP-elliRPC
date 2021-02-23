<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface SchemaReferenceDefinitionInterface
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

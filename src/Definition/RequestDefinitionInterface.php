<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface RequestDefinitionInterface
{
    /**
     * @return DataDefinitionInterface|null
     */
    public function getRequestDataDefinition(): ?DataDefinitionInterface;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getPaginatedByDefinition(): ?SchemaReferenceDefinitionInterface;

    /**
     * Returns an associative array where the key is the sort option and the the value is the description for
     * documentation purposes.
     *
     * @return string[]
     */
    public function getSortedByDefinition(): array;
}

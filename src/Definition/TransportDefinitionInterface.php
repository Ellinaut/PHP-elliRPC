<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface TransportDefinitionInterface extends DefinitionInterface
{
    /**
     * @return DataDefinitionInterface|null
     */
    public function getDataDefinition(): ?DataDefinitionInterface;

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getMetaDefinition(): ?SchemaReferenceDefinitionInterface;
}

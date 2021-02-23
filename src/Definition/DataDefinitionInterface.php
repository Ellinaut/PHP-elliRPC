<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface DataDefinitionInterface extends SchemaReferenceDefinitionInterface
{
    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getWrappedBy(): ?SchemaReferenceDefinitionInterface;
}

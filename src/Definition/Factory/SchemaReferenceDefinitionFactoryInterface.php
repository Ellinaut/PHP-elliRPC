<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface SchemaReferenceDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return SchemaReferenceDefinitionInterface
     */
    public function createDefinition(array $input): SchemaReferenceDefinitionInterface;
}

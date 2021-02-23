<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return SchemaDefinitionInterface
     */
    public function createDefinition(array $input): SchemaDefinitionInterface;
}

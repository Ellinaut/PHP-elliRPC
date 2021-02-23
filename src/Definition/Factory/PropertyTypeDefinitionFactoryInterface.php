<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PropertyTypeDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PropertyTypeDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return PropertyTypeDefinitionInterface
     */
    public function createDefinition(array $input): PropertyTypeDefinitionInterface;
}

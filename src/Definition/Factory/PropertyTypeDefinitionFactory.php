<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PropertyTypeDefinition;
use Ellinaut\ElliRPC\Definition\PropertyTypeDefinitionInterface;

/**
 * @author Philipp Marien
 */
class PropertyTypeDefinitionFactory implements PropertyTypeDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return PropertyTypeDefinitionInterface
     */
    public function createDefinition(array $input): PropertyTypeDefinitionInterface
    {
        return new PropertyTypeDefinition($input['context'], $input['type'], $input['options']);
    }
}

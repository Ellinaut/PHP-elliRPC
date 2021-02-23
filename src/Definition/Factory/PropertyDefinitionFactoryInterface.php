<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PropertyDefinitionFactoryInterface
{
    /**
     * @param string $name
     * @param array $input
     * @return PropertyDefinitionInterface
     */
    public function createDefinition(string $name, array $input): PropertyDefinitionInterface;
}

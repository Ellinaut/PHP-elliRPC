<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PropertyDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return PropertyDefinitionInterface
     */
    public function createDefinition(array $input): PropertyDefinitionInterface;
}

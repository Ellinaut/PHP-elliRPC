<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface DataDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return DataDefinitionInterface
     */
    public function createDefinition(array $input): DataDefinitionInterface;
}

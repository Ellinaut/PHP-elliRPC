<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return PackageDefinitionInterface
     */
    public function createDefinition(array $input): PackageDefinitionInterface;
}

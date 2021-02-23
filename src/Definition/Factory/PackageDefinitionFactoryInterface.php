<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionFactoryInterface
{
    /**
     * @param string $name
     * @param array $input
     * @return PackageDefinitionInterface
     */
    public function createDefinition(string $name, array $input): PackageDefinitionInterface;
}

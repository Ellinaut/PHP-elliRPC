<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionProviderInterface
{
    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackageDefinitions(): array;
}

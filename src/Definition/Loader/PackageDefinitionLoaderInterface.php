<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionLoaderException;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionLoaderInterface
{
    /**
     * @return PackageDefinitionInterface[]
     */
    public function loadPackageDefinitions(): array;

    /**
     * @param string $package
     * @return PackageDefinitionInterface
     * @throws DefinitionLoaderException
     */
    public function loadPackageDefinition(string $package): PackageDefinitionInterface;
}

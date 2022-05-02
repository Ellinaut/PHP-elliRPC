<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Exception\LoaderException;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionLoaderInterface
{
    /**
     * @param string $package
     * @return PackageDefinitionInterface
     * @throws LoaderException
     */
    public function loadPackageDefinition(string $package): PackageDefinitionInterface;
}

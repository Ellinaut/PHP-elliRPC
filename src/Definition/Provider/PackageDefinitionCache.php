<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Philipp Marien
 */
class PackageDefinitionCache implements PackageDefinitionProviderInterface
{
    /**
     * @var PackageDefinitionProviderInterface
     */
    private PackageDefinitionProviderInterface $packageDefinitionProvider;

    /**
     * @var CacheItemPoolInterface
     */
    private CacheItemPoolInterface $cacheItemPool;

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackageDefinitions(): array
    {
        // TODO: Implement getPackageDefinitions() method.
    }
}

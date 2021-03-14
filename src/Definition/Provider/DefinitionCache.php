<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Philipp Marien
 */
class DefinitionCache implements DefinitionProviderInterface
{
    /**
     * @var DefinitionProviderInterface
     */
    private DefinitionProviderInterface $definitionProvider;

    /**
     * @var CacheItemPoolInterface
     */
    private CacheItemPoolInterface $cacheItemPool;

    /**
     * @param DefinitionProviderInterface $definitionProvider
     * @param CacheItemPoolInterface $cacheItemPool
     */
    public function __construct(DefinitionProviderInterface $definitionProvider, CacheItemPoolInterface $cacheItemPool)
    {
        $this->definitionProvider = $definitionProvider;
        $this->cacheItemPool = $cacheItemPool;
    }

    /**
     * @return ApplicationDefinitionInterface
     */
    public function getApplicationDefinition(): ApplicationDefinitionInterface
    {
        // TODO: Implement getApplicationDefinition() method.
    }

    /**
     * @return array
     */
    public function getPackageDefinitions(): array
    {
        // TODO: Implement getPackageDefinitions() method.
    }

    /**
     * @param string $schemaName
     * @return SchemaDefinitionInterface
     */
    public function getSchemaDefinition(string $schemaName): SchemaDefinitionInterface
    {
        // TODO: Implement getSchemaDefinition() method.
    }
}

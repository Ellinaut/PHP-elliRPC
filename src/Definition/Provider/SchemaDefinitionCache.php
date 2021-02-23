<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Psr\Cache\CacheItemPoolInterface;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionCache implements SchemaDefinitionProviderInterface
{
    /**
     * @var SchemaDefinitionProviderInterface
     */
    private SchemaDefinitionProviderInterface $schemaDefinitionProvider;

    /**
     * @var CacheItemPoolInterface
     */
    private CacheItemPoolInterface $cacheItemPool;

    /**
     * @param string $name
     * @return SchemaDefinitionInterface
     */
    public function getSchemaDefinition(string $name): SchemaDefinitionInterface
    {
        // TODO: Implement getSchemaDefinition() method.
    }
}

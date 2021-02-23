<?php

namespace Ellinaut\ElliRPC\Client;

use Ellinaut\ElliRPC\Definition\Provider\PackageDefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\Provider\SchemaDefinitionProviderInterface;

/**
 * @author Philipp Marien
 */
class ElliRPCClient
{
    /**
     * @var PackageDefinitionProviderInterface
     */
    private PackageDefinitionProviderInterface $packageDefinitionProvider;

    /**
     * @var SchemaDefinitionProviderInterface
     */
    private SchemaDefinitionProviderInterface $schemaDefinitionProvider;
}

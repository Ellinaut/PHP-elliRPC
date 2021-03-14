<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface DefinitionProviderInterface
{
    /**
     * @return ApplicationDefinitionInterface
     */
    public function getApplicationDefinition(): ApplicationDefinitionInterface;

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackageDefinitions(): array;

    /**
     * @param string $schemaName
     * @return SchemaDefinitionInterface
     */
    public function getSchemaDefinition(string $schemaName): SchemaDefinitionInterface;
}

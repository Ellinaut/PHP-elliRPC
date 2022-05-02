<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Definition\Loader\PackageDefinitionLoaderInterface;
use Ellinaut\ElliRPC\Definition\Loader\ProcedureDefinitionLoaderInterface;
use Ellinaut\ElliRPC\Definition\Loader\SchemaDefinitionLoaderInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionHandler
{
    public function __construct(
        protected PackageDefinitionLoaderInterface $packageDefinitionLoader,
        protected ProcedureDefinitionLoaderInterface $procedureDefinitionLoader,
        protected SchemaDefinitionLoaderInterface $schemaDefinitionLoader
    ) {
    }

    public function getDocumentationJson(): string
    {
        //@todo load full application documentation and serialize it to json
    }

    /**
     * @param string $package
     * @return string
     * @throws Throwable
     */
    public function getPackageDefinitionJson(string $package): string
    {
        return json_encode($this->loadPackageDefinition($package), JSON_THROW_ON_ERROR);
    }

    /**
     * @param string $package
     * @return PackageDefinitionInterface
     * @throws Throwable
     */
    public function loadPackageDefinition(string $package): PackageDefinitionInterface
    {
        return $this->packageDefinitionLoader->loadPackageDefinition($package);
    }

    /**
     * @param string $package
     * @param string $procedure
     * @return ProcedureDefinitionInterface
     * @throws Throwable
     */
    public function loadProcedureDefinition(string $package, string $procedure): ProcedureDefinitionInterface
    {
        return $this->procedureDefinitionLoader->loadProcedureDefinition($package, $procedure);
    }

    /**
     * @param string $package
     * @param string $schema
     * @return SchemaDefinitionInterface
     * @throws Throwable
     */
    public function loadSchemaDefinition(string $package, string $schema): SchemaDefinitionInterface
    {
        return $this->schemaDefinitionLoader->loadSchemaDefinition($package, $schema);
    }
}

<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\ArrayDefinition\PackageDefinition;
use Ellinaut\ElliRPC\Definition\ArrayDefinition\ProcedureDefinition;
use Ellinaut\ElliRPC\Definition\ArrayDefinition\SchemaDefinition;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;
use Ellinaut\ElliRPC\Exception\DefinitionLoaderException;

/**
 * @author Philipp Marien
 */
class ArrayDefinitionLoader implements PackageDefinitionLoaderInterface, ProcedureDefinitionLoaderInterface, SchemaDefinitionLoaderInterface
{
    private array $packageArrayDefinitions = [];
    private array $procedureArrayDefinitions = [];
    private array $schemaArrayDefinitions = [];

    private array $packageDefinitions = [];
    private array $procedureDefinitions = [];
    private array $schemaDefinitions = [];

    /**
     * @param array $packageDefinition
     * @return void
     * @throws DefinitionLoaderException
     */
    public function registerPackage(array $packageDefinition): void
    {
        if (!array_key_exists('name', $packageDefinition)) {
            throw new DefinitionLoaderException('Try to register a package without name!');
        }
        $this->packageArrayDefinitions[$packageDefinition['name']] = $packageDefinition;

        if (!array_key_exists('procedures', $packageDefinition) || !is_array($packageDefinition['procedures'])) {
            throw new DefinitionLoaderException('Package definition does not contain required property "procedures"!');
        }

        foreach ($packageDefinition['procedures'] as $procedureDefinition) {
            if (!array_key_exists('name', $procedureDefinition)) {
                throw new DefinitionLoaderException('Try to register a procedure without name!');
            }
            $this->procedureArrayDefinitions[$packageDefinition['name']][$procedureDefinition['name']] = $procedureDefinition;
        }

        if (!array_key_exists('schemas', $packageDefinition) || !is_array($packageDefinition['schemas'])) {
            throw new DefinitionLoaderException('Package definition does not contain required property "schemas"!');
        }

        foreach ($packageDefinition['schemas'] as $schemaDefinition) {
            if (!array_key_exists('name', $schemaDefinition)) {
                throw new DefinitionLoaderException('Try to register a schema without name!');
            }
            $this->schemaArrayDefinitions[$packageDefinition['name']][$schemaDefinition['name']] = $schemaDefinition;
        }
    }

    /**
     * @return PackageDefinitionInterface[]
     * @throws DefinitionException
     * @throws DefinitionLoaderException
     */
    public function loadPackageDefinitions(): array
    {
        $packages = [];
        foreach (array_keys($this->packageArrayDefinitions) as $package) {
            $packages[] = $this->loadPackageDefinition($package);
        }

        return $packages;
    }

    /**
     * @param string $package
     * @return PackageDefinitionInterface
     * @throws DefinitionLoaderException
     * @throws DefinitionException
     */
    public function loadPackageDefinition(string $package): PackageDefinitionInterface
    {
        if (!array_key_exists($package, $this->packageDefinitions)) {
            if (!array_key_exists($package, $this->packageArrayDefinitions)) {
                throw new DefinitionLoaderException('Package "' . $package . '" is not registered.');
            }

            $this->packageDefinitions[$package] = new PackageDefinition($this->packageArrayDefinitions[$package]);
        }

        return $this->packageDefinitions[$package];
    }

    /**
     * @param string $package
     * @param string $procedure
     * @return ProcedureDefinitionInterface
     * @throws DefinitionException
     * @throws DefinitionLoaderException
     */
    public function loadProcedureDefinition(string $package, string $procedure): ProcedureDefinitionInterface
    {
        if (!array_key_exists($package, $this->procedureDefinitions) ||
            !array_key_exists($procedure, $this->procedureDefinitions[$package])) {
            if (!array_key_exists($package, $this->procedureArrayDefinitions) ||
                !array_key_exists($procedure, $this->procedureArrayDefinitions[$package])) {
                throw new DefinitionLoaderException('Procedure "' . $procedure . '" in package "' . $package . '" is not registered.');
            }

            $this->procedureDefinitions[$package][$procedure] = new ProcedureDefinition(
                $this->procedureArrayDefinitions[$package][$procedure]
            );
        }

        return $this->procedureDefinitions[$package][$procedure];
    }

    /**
     * @param string $package
     * @param string $schema
     * @return SchemaDefinitionInterface
     * @throws DefinitionException
     * @throws DefinitionLoaderException
     */
    public function loadSchemaDefinition(string $package, string $schema): SchemaDefinitionInterface
    {
        if (!array_key_exists($package, $this->schemaDefinitions) ||
            !array_key_exists($schema, $this->schemaDefinitions[$package])) {
            if (!array_key_exists($package, $this->schemaArrayDefinitions) ||
                !array_key_exists($schema, $this->schemaArrayDefinitions[$package])) {
                throw new DefinitionLoaderException('Schema "' . $schema . '" in package "' . $package . '" is not registered.');
            }

            $this->schemaDefinitions[$package][$schema] = new SchemaDefinition(
                $this->schemaArrayDefinitions[$package][$schema]
            );
        }

        return $this->schemaDefinitions[$package][$schema];
    }
}

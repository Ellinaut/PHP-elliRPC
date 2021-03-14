<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\ApplicationDefinition;
use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;

/**
 * @author Philipp Marien
 */
class ApplicationDefinitionFactory implements ApplicationDefinitionFactoryInterface
{
    /**
     * @var PackageDefinitionFactoryInterface
     */
    private PackageDefinitionFactoryInterface $packageDefinitionFactory;

    /**
     * @var SchemaDefinitionFactoryInterface
     */
    private SchemaDefinitionFactoryInterface $schemaDefinitionFactory;

    /**
     * @param PackageDefinitionFactoryInterface $packageDefinitionFactory
     * @param SchemaDefinitionFactoryInterface $schemaDefinitionFactory
     */
    public function __construct(
        PackageDefinitionFactoryInterface $packageDefinitionFactory,
        SchemaDefinitionFactoryInterface $schemaDefinitionFactory
    ) {
        $this->packageDefinitionFactory = $packageDefinitionFactory;
        $this->schemaDefinitionFactory = $schemaDefinitionFactory;
    }

    /**
     * @param array $input
     * @return ApplicationDefinitionInterface
     */
    public function createDefinition(array $input): ApplicationDefinitionInterface
    {
        $packages = [];
        foreach ($input['packages'] as $package) {
            $packages[] = $this->packageDefinitionFactory->createDefinition($package);
        }

        $schemas = [];
        foreach ($input['schemas'] as $schema) {
            $schemas[] = $this->schemaDefinitionFactory->createDefinition($schema);
        }

        return new ApplicationDefinition(
            $input['application'],
            $input['contentTypes'],
            $input['description'] ?? null,
            $packages,
            $schemas
        );
    }
}

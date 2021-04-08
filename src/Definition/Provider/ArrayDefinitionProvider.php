<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\Factory\ApplicationDefinitionFactoryInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\SchemaDefinitionNotFoundException;
use Throwable;

/**
 * @author Philipp Marien
 */
class ArrayDefinitionProvider implements DefinitionProviderInterface
{
    /**
     * @var ApplicationDefinitionFactoryInterface
     */
    private ApplicationDefinitionFactoryInterface $applicationDefinitionFactory;

    /**
     * @var array
     */
    private array $rawApplicationDefinition;

    /**
     * @var ApplicationDefinitionInterface|null
     */
    private ?ApplicationDefinitionInterface $applicationDefinition = null;

    /**
     * @param ApplicationDefinitionFactoryInterface $applicationDefinitionFactory
     * @param array $rawApplicationDefinition
     */
    public function __construct(
        ApplicationDefinitionFactoryInterface $applicationDefinitionFactory,
        array $rawApplicationDefinition
    ) {
        $this->applicationDefinitionFactory = $applicationDefinitionFactory;
        $this->rawApplicationDefinition = $rawApplicationDefinition;
    }

    /**
     * @return ApplicationDefinitionInterface
     */
    public function getApplicationDefinition(): ApplicationDefinitionInterface
    {
        if (!$this->applicationDefinition) {
            $this->applicationDefinition = $this->applicationDefinitionFactory->createDefinition(
                $this->rawApplicationDefinition
            );
        }

        return $this->applicationDefinition;
    }

    /**
     * @return array
     */
    public function getPackageDefinitions(): array
    {
        return $this->getApplicationDefinition()->getPackages();
    }

    /**
     * @param string $schemaName
     * @return SchemaDefinitionInterface
     * @throws Throwable
     */
    public function getSchemaDefinition(string $schemaName): SchemaDefinitionInterface
    {
        foreach ($this->getApplicationDefinition()->getSchemas() as $schemaDefinition) {
            if ($schemaDefinition->getName() === $schemaName) {
                return $schemaDefinition;
            }
        }

        throw new SchemaDefinitionNotFoundException($schemaName);
    }
}

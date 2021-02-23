<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PackageDefinition;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
class PackageDefinitionFactory implements PackageDefinitionFactoryInterface
{
    /**
     * @var ProcedureDefinitionFactoryInterface
     */
    private ProcedureDefinitionFactoryInterface $procedureDefinitionFactory;

    /**
     * @param ProcedureDefinitionFactoryInterface $procedureDefinitionFactory
     */
    public function __construct(ProcedureDefinitionFactoryInterface $procedureDefinitionFactory)
    {
        $this->procedureDefinitionFactory = $procedureDefinitionFactory;
    }

    /**
     * @param string $name
     * @param array $input
     * @return PackageDefinitionInterface
     */
    public function createDefinition(string $name, array $input): PackageDefinitionInterface
    {
        $procedureDefinitions = [];

        foreach ($input as $procedureName => $procedureDefinition) {
            $procedureDefinitions[] = $this->procedureDefinitionFactory->createDefinition(
                $procedureName,
                $procedureDefinition
            );
        }

        return new PackageDefinition($name, $procedureDefinitions);
    }
}

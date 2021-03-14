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
     * @param array $input
     * @return PackageDefinitionInterface
     */
    public function createDefinition(array $input): PackageDefinitionInterface
    {
        $procedureDefinitions = [];

        foreach ($input['procedures'] as $procedure) {
            $procedureDefinitions[] = $this->procedureDefinitionFactory->createDefinition($procedure);
        }

        return new PackageDefinition($input['name'], $input['description'] ?? null, $procedureDefinitions);
    }
}

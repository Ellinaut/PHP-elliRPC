<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\ProcedureDefinition;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;

/**
 * @author Philipp Marien
 */
class ProcedureDefinitionFactory implements ProcedureDefinitionFactoryInterface
{
    /**
     * @var RequestDefinitionFactoryInterface
     */
    private RequestDefinitionFactoryInterface $requestDefinitionFactory;

    /**
     * @var DataDefinitionFactoryInterface
     */
    private DataDefinitionFactoryInterface $dataDefinitionFactory;

    /**
     * @param RequestDefinitionFactoryInterface $requestDefinitionFactory
     * @param DataDefinitionFactoryInterface $dataDefinitionFactory
     */
    public function __construct(
        RequestDefinitionFactoryInterface $requestDefinitionFactory,
        DataDefinitionFactoryInterface $dataDefinitionFactory
    ) {
        $this->requestDefinitionFactory = $requestDefinitionFactory;
        $this->dataDefinitionFactory = $dataDefinitionFactory;
    }

    /**
     * @param array $input
     * @return ProcedureDefinitionInterface
     */
    public function createDefinition(array $input): ProcedureDefinitionInterface
    {
        return new ProcedureDefinition(
            $input['name'],
            $input['description'] ?? null,
            $input['methods'],
            $input['contentTypes'],
            $this->requestDefinitionFactory->createDefinition($input['request']),
            $this->dataDefinitionFactory->createDefinition($input['response'])
        );
    }
}

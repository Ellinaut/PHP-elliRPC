<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\RequestDefinition;
use Ellinaut\ElliRPC\Definition\RequestDefinitionInterface;

/**
 * @author Philipp Marien
 */
class RequestDefinitionFactory implements RequestDefinitionFactoryInterface
{
    /**
     * @var DataDefinitionFactoryInterface
     */
    private DataDefinitionFactoryInterface $dataDefinitionFactory;

    /**
     * @var SchemaReferenceDefinitionFactoryInterface
     */
    private SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory;

    /**
     * @param DataDefinitionFactoryInterface $dataDefinitionFactory
     * @param SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory
     */
    public function __construct(
        DataDefinitionFactoryInterface $dataDefinitionFactory,
        SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory
    ) {
        $this->dataDefinitionFactory = $dataDefinitionFactory;
        $this->schemaReferenceDefinitionFactory = $schemaReferenceDefinitionFactory;
    }

    /**
     * @param array $input
     * @return RequestDefinitionInterface
     */
    public function createDefinition(array $input): RequestDefinitionInterface
    {
        return new RequestDefinition(
            $this->dataDefinitionFactory->createDefinition($input['data']),
            $this->schemaReferenceDefinitionFactory->createDefinition($input['paginatedBy']),
            $input['sortedBy']
        );
    }
}

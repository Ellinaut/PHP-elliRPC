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
        $data = null;
        if (is_array($input['data'])) {
            $data = $this->dataDefinitionFactory->createDefinition($input['data']);
        }

        $paginatedBy = null;
        if (is_array($input['paginatedBy'])) {
            $paginatedBy = $this->schemaReferenceDefinitionFactory->createDefinition($input['paginatedBy']);
        }

        return new RequestDefinition(
            $data,
            $paginatedBy,
            $input['sortedBy']
        );
    }
}

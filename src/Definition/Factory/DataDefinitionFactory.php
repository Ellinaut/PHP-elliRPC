<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\DataDefinition;
use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;

/**
 * @author Philipp Marien
 */
class DataDefinitionFactory implements DataDefinitionFactoryInterface
{
    /**
     * @var SchemaReferenceDefinitionFactoryInterface
     */
    private SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory;

    /**
     * @param SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory
     */
    public function __construct(SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory)
    {
        $this->schemaReferenceDefinitionFactory = $schemaReferenceDefinitionFactory;
    }

    /**
     * @param array $input
     * @return DataDefinitionInterface
     */
    public function createDefinition(array $input): DataDefinitionInterface
    {
        $wrappedBy = null;
        if (is_array($input['wrappedBy'])) {
            $wrappedBy = $this->schemaReferenceDefinitionFactory->createDefinition($input['wrappedBy']);
        }

        return new DataDefinition($input['context'], $input['schema'], $wrappedBy);
    }
}

<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinition;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;

/**
 * @author Philipp Marien
 */
class SchemaReferenceDefinitionFactory implements SchemaReferenceDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return SchemaReferenceDefinitionInterface
     */
    public function createDefinition(array $input): SchemaReferenceDefinitionInterface
    {
        return new SchemaReferenceDefinition($input['context'], $input['schema']);
    }
}

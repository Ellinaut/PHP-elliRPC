<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\SchemaDefinition;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionFactory implements SchemaDefinitionFactoryInterface
{
    /**
     * @var SchemaReferenceDefinitionFactoryInterface
     */
    private SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory;

    /**
     * @var PropertyDefinitionFactoryInterface
     */
    private PropertyDefinitionFactoryInterface $propertyDefinitionFactory;

    /**
     * @param SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory
     * @param PropertyDefinitionFactoryInterface $propertyDefinitionFactory
     */
    public function __construct(
        SchemaReferenceDefinitionFactoryInterface $schemaReferenceDefinitionFactory,
        PropertyDefinitionFactoryInterface $propertyDefinitionFactory
    ) {
        $this->schemaReferenceDefinitionFactory = $schemaReferenceDefinitionFactory;
        $this->propertyDefinitionFactory = $propertyDefinitionFactory;
    }

    /**
     * @param array $input
     * @return SchemaDefinitionInterface
     */
    public function createDefinition(array $input): SchemaDefinitionInterface
    {
        $propertyDefinitions = [];
        foreach ($input['properties'] as $property) {
            $propertyDefinitions[] = $this->propertyDefinitionFactory->createDefinition($property);
        }

        $extends = null;
        if (is_array($input['extends'])) {
            $extends = $this->schemaReferenceDefinitionFactory->createDefinition($input['extends']);
        }

        return new SchemaDefinition(
            $input['name'],
            (bool)$input['abstract'],
            $extends,
            $input['description'],
            $propertyDefinitions
        );
    }
}

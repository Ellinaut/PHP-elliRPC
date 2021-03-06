<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\PropertyDefinition;
use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;

/**
 * @author Philipp Marien
 */
class PropertyDefinitionFactory implements PropertyDefinitionFactoryInterface
{
    /**
     * @var PropertyTypeDefinitionFactoryInterface
     */
    private PropertyTypeDefinitionFactoryInterface $propertyTypeDefinitionFactory;

    /**
     * @param PropertyTypeDefinitionFactoryInterface $propertyTypeDefinitionFactory
     */
    public function __construct(PropertyTypeDefinitionFactoryInterface $propertyTypeDefinitionFactory)
    {
        $this->propertyTypeDefinitionFactory = $propertyTypeDefinitionFactory;
    }

    /**
     * @param array $input
     * @return PropertyDefinitionInterface
     */
    public function createDefinition(array $input): PropertyDefinitionInterface
    {
        return new PropertyDefinition(
            $input['name'],
            $input['description'],
            $this->propertyTypeDefinitionFactory->createDefinition($input['type'])
        );
    }
}

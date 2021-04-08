<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;

/**
 * @author Philipp Marien
 */
trait DefinitionMapperTrait
{
    /**
     * @param PackageDefinitionInterface[] $packageDefinitions
     * @return array
     */
    protected function mapPackageDefinitionsToArray(array $packageDefinitions): array
    {
        $packageDefinitionData = [];

        foreach ($packageDefinitions as $packageDefinition) {
            $procedureDefinitions = [];
            foreach ($packageDefinition->getProcedureDefinitions() as $procedureDefinition) {
                $procedureDefinitions[] = $this->mapProcedureDefinitionToArray($procedureDefinition);
            }

            $packageDefinitionData[] = [
                'name' => $packageDefinition->getName(),
                'description' => $packageDefinition->getDescription(),
                'procedures' => $procedureDefinitions
            ];
        }
        return $packageDefinitionData;
    }

    /**
     * @param SchemaDefinitionInterface $schemaDefinition
     * @return array
     */
    protected function mapSchemaDefinitionToArray(SchemaDefinitionInterface $schemaDefinition): array
    {
        $extends = null;
        if ($schemaDefinition->getExtendsDefinition()) {
            $extends = [
                'context' => $schemaDefinition->getExtendsDefinition()->getContext(),
                'schema' => $schemaDefinition->getExtendsDefinition()->getSchema(),
            ];
        }

        $propertyDefinitionData = [];
        foreach ($schemaDefinition->getPropertyDefinitions() as $propertyDefinition) {
            $propertyDefinitionData[] = $this->mapPropertyDefinitionToArray($propertyDefinition);
        }

        return [
            'name' => $schemaDefinition->getName(),
            'abstract' => $schemaDefinition->isAbstract(),
            'extends' => $extends,
            'description' => $schemaDefinition->getDescription(),
            'properties' => $propertyDefinitionData
        ];
    }

    /**
     * @param ProcedureDefinitionInterface $definition
     * @return array
     */
    protected function mapProcedureDefinitionToArray(ProcedureDefinitionInterface $definition): array
    {
        $paginatedBy = null;
        if ($definition->getRequestDefinition()->getPaginatedByDefinition()) {
            $paginatedBy = $this->mapSchemaReferenceDefinitionToArray(
                $definition->getRequestDefinition()->getPaginatedByDefinition()
            );
        }

        $data = $definition->getRequestDefinition()->getRequestDataDefinition();
        $requestDefinitionData = [
            'data' => $data ? $this->mapDataDefinitionToArray($data) : null,
            'paginatedBy' => $paginatedBy,
            'sortedBy' => $definition->getRequestDefinition()->getSortedByDefinition()
        ];

        $response = $definition->getResponseDataDefinition();

        return [
            'name' => $definition->getName(),
            'description' => $definition->getDescription(),
            'methods' => $definition->getMethods(),
            'contentTypes' => $definition->getContentTypes(),
            'request' => $requestDefinitionData,
            'response' => $response ? $this->mapDataDefinitionToArray($response) : null,
        ];
    }

    /**
     * @param DataDefinitionInterface $definition
     * @return array
     */
    protected function mapDataDefinitionToArray(DataDefinitionInterface $definition): array
    {
        $dataDefinitionData = $this->mapSchemaReferenceDefinitionToArray($definition);

        $dataDefinitionData['wrappedBy'] = null;
        if ($definition->getWrappedBy()) {
            $dataDefinitionData['wrappedBy'] = $this->mapSchemaReferenceDefinitionToArray($definition->getWrappedBy());
        }

        return $dataDefinitionData;
    }

    /**
     * @param SchemaReferenceDefinitionInterface $definition
     * @return array
     */
    protected function mapSchemaReferenceDefinitionToArray(SchemaReferenceDefinitionInterface $definition): array
    {
        return [
            'context' => $definition->getContext(),
            'schema' => $definition->getSchema(),
        ];
    }

    /**
     * @param PropertyDefinitionInterface $definition
     * @return array
     */
    protected function mapPropertyDefinitionToArray(PropertyDefinitionInterface $definition): array
    {
        return [
            'name' => $definition->getName(),
            'description' => $definition->getDescription(),
            'type' => [
                'context' => $definition->getPropertyTypeDefinition()->getContext(),
                'type' => $definition->getPropertyTypeDefinition()->getType(),
                'options' => $definition->getPropertyTypeDefinition()->getOptions(),
            ],
        ];
    }
}

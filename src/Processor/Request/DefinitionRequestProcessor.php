<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PropertyDefinitionInterface;
use Ellinaut\ElliRPC\Definition\Provider\DefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\DocumentationRequest;
use Ellinaut\ElliRPC\Request\PackageDefinitionsRequest;
use Ellinaut\ElliRPC\Request\SchemaDefinitionRequest;
use Ellinaut\ElliRPC\ResponseFactory\AbstractResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionRequestProcessor extends AbstractResponseFactory implements RequestProcessorInterface
{
    /**
     * @var DefinitionProviderInterface
     */
    private DefinitionProviderInterface $definitionProvider;

    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if ($request instanceof DocumentationRequest) {
            return $this->createDocumentationResponse(
                $this->definitionProvider->getApplicationDefinition()
            );
        }

        if ($request instanceof PackageDefinitionsRequest) {
            return $this->createPackagesResponse(
                $this->definitionProvider->getPackageDefinitions()
            );
        }

        if ($request instanceof SchemaDefinitionRequest) {
            return $this->createSchemaResponse(
                $this->definitionProvider->getSchemaDefinition($request->getSchemaName())
            );
        }

        //@todo exception
    }

    /**
     * @param ApplicationDefinitionInterface $application
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createDocumentationResponse(ApplicationDefinitionInterface $application): ResponseInterface
    {
        $schemaDefinitionsData = [];
        foreach ($application->getSchemas() as $schemaDefinition) {
            $schemaDefinitionsData[] = $this->mapSchemaDefinitionToArray($schemaDefinition);
        }

        return $this->createJsonResponse([
            'application' => $application->getName(),
            'contentTypes' => $application->getContentTypes(),
            'description' => $application->getDescription(),
            'packages' => $this->mapPackageDefinitionsToArray($application->getPackages()),
            'schemas' => $schemaDefinitionsData
        ]);
    }

    /**
     * @param PackageDefinitionInterface[] $packages
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createPackagesResponse(array $packages): ResponseInterface
    {
        return $this->createJsonResponse(['packages' => $this->mapPackageDefinitionsToArray($packages)]);
    }

    /**
     * @param SchemaDefinitionInterface $schema
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createSchemaResponse(SchemaDefinitionInterface $schema): ResponseInterface
    {
        return $this->createJsonResponse($this->mapSchemaDefinitionToArray($schema));
    }

    /**
     * @param PackageDefinitionInterface[] $packageDefinitions
     * @return array
     */
    private function mapPackageDefinitionsToArray(array $packageDefinitions): array
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
    private function mapSchemaDefinitionToArray(SchemaDefinitionInterface $schemaDefinition): array
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
    private function mapProcedureDefinitionToArray(ProcedureDefinitionInterface $definition): array
    {
        $paginatedBy = null;
        if ($definition->getRequestDefinition()->getPaginatedByDefinition()) {
            $paginatedBy = $this->mapSchemaReferenceDefinitionToArray(
                $definition->getRequestDefinition()->getPaginatedByDefinition()
            );
        }

        $requestDefinitionData = [
            'data' => $this->mapDataDefinitionToArray($definition->getRequestDefinition()->getRequestDataDefinition()),
            'paginatedBy' => $paginatedBy,
            'sortedBy' => $definition->getRequestDefinition()->getSortedByDefinition()
        ];

        return [
            'name' => $definition->getName(),
            'description' => $definition->getDescription(),
            'methods' => $definition->getMethods(),
            'contentTypes' => $definition->getContentTypes(),
            'request' => $requestDefinitionData,
            'response' => $this->mapDataDefinitionToArray($definition->getResponseDataDefinition()),
        ];
    }

    /**
     * @param DataDefinitionInterface $definition
     * @return array
     */
    private function mapDataDefinitionToArray(DataDefinitionInterface $definition): array
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
    private function mapSchemaReferenceDefinitionToArray(SchemaReferenceDefinitionInterface $definition): array
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
    private function mapPropertyDefinitionToArray(PropertyDefinitionInterface $definition): array
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

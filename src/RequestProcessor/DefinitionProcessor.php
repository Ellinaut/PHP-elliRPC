<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\DocumentationRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\PackageDefinitionsRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\SchemaDefinitionRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\DocumentationResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\PackageDefinitionsResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\SchemaDefinitionResponse;
use Ellinaut\ElliRPC\Definition\Provider\DefinitionProviderInterface;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;

/**
 * @author Philipp Marien
 */
class DefinitionProcessor implements RequestProcessorInterface
{
    /**
     * @var DefinitionProviderInterface
     */
    private DefinitionProviderInterface $definitionProvider;

    /**
     * @param DefinitionProviderInterface $definitionProvider
     */
    public function __construct(DefinitionProviderInterface $definitionProvider)
    {
        $this->definitionProvider = $definitionProvider;
    }

    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if ($request instanceof DocumentationRequest) {
            return new DocumentationResponse(
                $request->getContext(),
                $this->definitionProvider->getApplicationDefinition()
            );
        }

        if ($request instanceof PackageDefinitionsRequest) {
            return new PackageDefinitionsResponse(
                $request->getContext(),
                $this->definitionProvider->getPackageDefinitions()
            );
        }

        if ($request instanceof SchemaDefinitionRequest) {
            return new SchemaDefinitionResponse(
                $request->getContext(),
                $this->definitionProvider->getSchemaDefinition($request->getSchemaName())
            );
        }

        throw new InvalidRequestProcessorException();
    }
}

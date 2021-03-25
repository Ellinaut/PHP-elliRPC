<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\DefinitionResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\DocumentationResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\PackageDefinitionsResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\SchemaDefinitionResponse;
use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\Provider\DefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\DocumentationRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\PackageDefinitionsRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\SchemaDefinitionRequest;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionProcessor extends AbstractRequestProcessor
{
    /**
     * @var DefinitionProviderInterface
     */
    private DefinitionProviderInterface $definitionProvider;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param DefinitionProviderInterface $definitionProvider
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        DefinitionProviderInterface $definitionProvider
    ) {
        parent::__construct($responseFactory);
        $this->definitionProvider = $definitionProvider;
    }

    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if ($request instanceof DocumentationRequest) {
            return $this->createDocumentationResponse(
                $request->getRequestedContentType(),
                $this->definitionProvider->getApplicationDefinition()
            );
        }

        if ($request instanceof PackageDefinitionsRequest) {
            return $this->createPackagesResponse(
                $request->getRequestedContentType(),
                $this->definitionProvider->getPackageDefinitions()
            );
        }

        if ($request instanceof SchemaDefinitionRequest) {
            return $this->createSchemaResponse(
                $request->getRequestedContentType(),
                $this->definitionProvider->getSchemaDefinition($request->getSchemaName())
            );
        }

        throw new InvalidRequestProcessorException();
    }

    /**
     * @param string $contentType
     * @param ApplicationDefinitionInterface $application
     * @return ResponseInterface
     */
    public function createDocumentationResponse(
        string $contentType,
        ApplicationDefinitionInterface $application
    ): ResponseInterface {
        return $this->createResponse(
            new DocumentationResponse(
                $responseContext = new DefinitionResponseContext(
                    $contentType,
                    DefinitionResponseContext::ENDPOINT_DOCUMENTATION
                ),
                $application
            )
        );
    }

    /**
     * @param string $contentType
     * @param PackageDefinitionInterface[] $packages
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createPackagesResponse(string $contentType, array $packages): ResponseInterface
    {
        return $this->createResponse(
            new PackageDefinitionsResponse(
                new DefinitionResponseContext(
                    $contentType,
                    DefinitionResponseContext::ENDPOINT_PACKAGES
                ),
                $packages
            )
        );
    }

    /**
     * @param string $contentType
     * @param SchemaDefinitionInterface $schema
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createSchemaResponse(string $contentType, SchemaDefinitionInterface $schema): ResponseInterface
    {
        return $this->createResponse(
            new SchemaDefinitionResponse(
                new DefinitionResponseContext(
                    $contentType,
                    DefinitionResponseContext::ENDPOINT_SCHEMA
                ),
                $schema
            )
        );
    }
}

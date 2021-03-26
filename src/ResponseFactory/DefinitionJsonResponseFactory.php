<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\DefinitionResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\DocumentationResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\PackageDefinitionsResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\SchemaDefinitionResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionJsonResponseFactory extends AbstractResponseFactory
{
    use DefinitionMapperTrait;

    /**
     * @param AbstractResponseContext $context
     * @return bool
     */
    public function supports(AbstractResponseContext $context): bool
    {
        if (!$context instanceof DefinitionResponseContext) {
            return false;
        }

        if ($context->getContentType() !== 'json') {
            return false;
        }

        return in_array(
            $context->getDefinitionEndpoint(),
            [
                DefinitionResponseContext::ENDPOINT_DOCUMENTATION,
                DefinitionResponseContext::ENDPOINT_PACKAGES,
                DefinitionResponseContext::ENDPOINT_SCHEMA,
            ],
            true
        );
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if ($formatableResponse instanceof DocumentationResponse) {
            $application = $formatableResponse->getContent();

            $schemaDefinitionsData = [];
            foreach ($application->getSchemas() as $schemaDefinition) {
                $schemaDefinitionsData[] = $this->mapSchemaDefinitionToArray($schemaDefinition);
            }

            return $this->createHttpResponseWithBody(
                json_encode(
                    [
                        'application' => $application->getName(),
                        'contentTypes' => $application->getContentTypes(),
                        'description' => $application->getDescription(),
                        'packages' => $this->mapPackageDefinitionsToArray($application->getPackages()),
                        'schemas' => $schemaDefinitionsData
                    ],
                    JSON_THROW_ON_ERROR
                ),
                'application/json'
            );
        }

        if ($formatableResponse instanceof PackageDefinitionsResponse) {
            return $this->createHttpResponseWithBody(
                json_encode(
                    [
                        'packages' => $this->mapPackageDefinitionsToArray($formatableResponse->getContent())
                    ],
                    JSON_THROW_ON_ERROR
                ),
                'application/json'
            );
        }

        if ($formatableResponse instanceof SchemaDefinitionResponse) {
            return $this->createHttpResponseWithBody(
                json_encode(
                    [
                        'packages' => $this->mapSchemaDefinitionToArray($formatableResponse->getContent())
                    ],
                    JSON_THROW_ON_ERROR
                ),
                'application/json'
            );
        }

        throw new UnsupportedResponseException();
    }
}

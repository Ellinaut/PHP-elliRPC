<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\DefinitionContext;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\DocumentationRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\PackageDefinitionsRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\SchemaDefinitionRequest;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     * @throws Throwable
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        // only http method GET is allowed for definitions requests
        if (strtoupper($request->getMethod()) !== 'GET') {
            return null;
        }

        $endpoint = $this->parseEndpointFromUri($request->getUri());
        if ($endpoint !== '@definitions') {
            return null;
        }

        $context = new DefinitionContext(
            $this->parseContentTypeExtensionFromUri($request->getUri()),
            $request->getHeader('Accept'),
            explode('/', $this->parseAdjustedPathFromUri($request->getUri()), 2)[0]
        );

        switch ($context->getDefinitionEndpoint()) {
            case DefinitionContext::ENDPOINT_APPLICATION:
                return new DocumentationRequest(
                    $context,
                    $request->getHeaders()
                );
            case DefinitionContext::ENDPOINT_PACKAGES:
                return new PackageDefinitionsRequest(
                    $context,
                    $request->getHeaders()
                );
            case DefinitionContext::ENDPOINT_SCHEMAS:
                return new SchemaDefinitionRequest(
                    $context,
                    $this->parseAdjustedPathFromUri($request->getUri()),
                    $request->getHeaders()
                );
        }

        return null;
    }
}

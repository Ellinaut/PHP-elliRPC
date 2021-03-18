<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\DocumentationRequest;
use Ellinaut\ElliRPC\Request\PackageDefinitionsRequest;
use Ellinaut\ElliRPC\Request\SchemaDefinitionRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class DefinitionRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        // only http method GET is allowed for definitions requests
        if (strtoupper($request->getMethod()) !== 'GET') {
            return null;
        }

        switch ($this->parseEndpointFromUri($request->getUri())) {
            case '_documentation':
                return new DocumentationRequest(
                    $request->getHeaders(),
                    $this->parseContentTypeExtensionFromUri($request->getUri())
                );
            case '_packages':
                return new PackageDefinitionsRequest(
                    $request->getHeaders(),
                    $this->parseContentTypeExtensionFromUri($request->getUri())
                );
            case '_schema':
                return new SchemaDefinitionRequest(
                    $request->getHeaders(),
                    $this->parseContentTypeExtensionFromUri($request->getUri()),
                    $this->parseAdjustedPathFromUri($request->getUri()),
                );
        }

        return null;
    }
}

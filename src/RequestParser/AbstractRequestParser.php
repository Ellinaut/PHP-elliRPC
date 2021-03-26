<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Exception\EndpointNotFoundException;
use Psr\Http\Message\UriInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractRequestParser implements RequestParserInterface
{
    /**
     * @param UriInterface $uri
     * @return string
     * @throws Throwable
     */
    protected function parseRpcPathFromUri(UriInterface $uri): string
    {
        $path = $uri->getPath();

        // remove content type from path
        $parts = explode('.', $path);
        if (count($parts) > 1) {
            array_pop($parts);
        }
        $path = implode('.', $parts);

        $matches = [];
        preg_match('/(elliRPC\/)(.*)/', $path, $matches);

        if (!array_key_exists(2, $matches)) {
            throw new EndpointNotFoundException();
        }

        return $matches[2];
    }

    /**
     * @param UriInterface $uri
     * @return string
     * @throws Throwable
     */
    protected function parseEndpointFromUri(UriInterface $uri): string
    {
        $endpointPath = $this->parseRpcPathFromUri($uri);
        $endpointPathParts = explode('/', $endpointPath, 2);

        return $endpointPathParts[0];
    }

    /**
     * @param UriInterface $uri
     * @return string|null
     * @throws Throwable
     */
    protected function parseAdjustedPathFromUri(UriInterface $uri): ?string
    {
        $endpointPath = $this->parseRpcPathFromUri($uri);
        $endpointPathParts = explode('/', $endpointPath, 2);

        if (count($endpointPathParts) !== 2) {
            return null;
        }

        return $endpointPathParts[1];
    }

    /**
     * @param UriInterface $uri
     * @return string
     */
    protected function parseContentTypeExtensionFromUri(UriInterface $uri): string
    {
        $parts = explode('.', $uri->getPath());

        return end($parts);
    }

    /**
     * @param UriInterface $uri
     * @return array
     */
    protected function parseQueryFromUri(UriInterface $uri): array
    {
        $query = [];
        parse_str($uri->getQuery(), $query);

        return $query;
    }
}

<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\ProcedureExecutionRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        // only http methods GET and POST are allowed for definitions requests
        if (!in_array(strtoupper($request->getMethod()), ['GET', 'POST'], true)) {
            return null;
        }

        [$packageName, $procedureName] = explode('/', $this->parseRpcPathFromUri($request->getUri()));
        if (!$packageName || !$procedureName) {
            return null;
        }

        // return null, if package name is a reserved key
        if ($packageName[0] === '_' || $packageName === '@files') {
            return null;
        }

        $query = [];
        parse_str($request->getUri()->getQuery(), $query);

        $body = $request->getBody()->getContents();
        if (empty($body)) {
            $body = null;
        }

        return new ProcedureExecutionRequest(
            $request->getHeaders(),
            $this->parseContentTypeExtensionFromUri($request->getUri()),
            $packageName,
            $procedureName,
            $query,
            $body
        );
    }
}

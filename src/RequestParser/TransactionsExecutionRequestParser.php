<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\TransactionsExecutionRequest;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class TransactionsExecutionRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     * @throws Throwable
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        // only http method POST is allowed for definitions requests
        if (strtoupper($request->getMethod()) !== 'POST') {
            return null;
        }

        $contentType = $this->parseContentTypeExtensionFromUri($request->getUri());
        // only json is allowed as content type for this action
        if ($contentType !== 'json') {
            return null;
        }

        // the body for this request MUST contain only json
        $contentTypeHeader = $request->getHeader('Content-Type');
        if (empty($contentTypeHeader) || $contentTypeHeader[0] !== 'application/json') {
            //@todo exception for invalid request
        }

        $body = json_decode(
            $request->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );

        if (!array_key_exists('transactions', $body) || !is_array($body['transactions'])) {
            //@todo exception for invalid request
        }

        return new TransactionsExecutionRequest(
            $request->getHeaders(),
            $contentType,
            $body['transactions']
        );
    }
}

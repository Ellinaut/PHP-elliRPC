<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\ProcedureBody;
use Ellinaut\ElliRPC\DataTransfer\ProcedureDefinition;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\Exception\InvalidContentTypeHeaderException;
use Ellinaut\ElliRPC\Exception\InvalidRequestBodyException;
use JsonException;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractBulkRequestParser extends AbstractRequestParser
{
    /**
     * @return string
     */
    abstract protected function getPath(): string;

    /**
     * @param array $procedures
     * @param RequestInterface $request
     * @return AbstractRequest
     */
    abstract protected function createRequest(array $procedures, RequestInterface $request): AbstractRequest;

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

        $endpoint = $this->parseRpcPathFromUri($request->getUri());
        if ($endpoint !== $this->getPath()) {
            return null;
        }

        $contentType = $this->parseContentTypeExtensionFromUri($request->getUri());
        // only json is allowed as content type for this action
        if ($contentType !== 'json') {
            return null;
        }

        // the body for this request MUST contain only json
        if ($request->getHeaderLine('Content-Type') !== 'application/json') {
            throw new InvalidContentTypeHeaderException();
        }

        try {
            $body = json_decode(
                $request->getBody()->getContents(),
                true,
                512,
                JSON_THROW_ON_ERROR
            );
        } catch (JsonException $exception) {
            throw new InvalidRequestBodyException();
        }

        if (!array_key_exists('procedures', $body) || !is_array($body['procedures'])) {
            throw new InvalidRequestBodyException();
        }

        $procedures = [];
        foreach ($body['procedures'] as $procedure) {
            $procedures[] = new Procedure(
                new ProcedureDefinition($procedure['package'], $procedure['procedure']),
                new ProcedureBody(
                    $procedure['pagination'] ?? [],
                    $procedure['sorting'] ?? null,
                    $procedure['data'] ?? null
                )
            );
        }

        return $this->createRequest($procedures, $request);
    }
}

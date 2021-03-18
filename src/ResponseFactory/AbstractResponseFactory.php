<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractResponseFactory
{
    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory, StreamFactoryInterface $streamFactory)
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param string $body
     * @param int $httpStatusCode
     * @return ResponseInterface
     */
    protected function createResponseWithBody(string $body, int $httpStatusCode = 200): ResponseInterface
    {
        return $this->responseFactory
            ->createResponse($httpStatusCode)
            ->withBody($this->streamFactory->createStream($body));
    }

    /**
     * @param array $data
     * @param int $httpStatusCode
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function createJsonResponse(array $data, int $httpStatusCode = 200): ResponseInterface
    {
        $response = $this->createResponseWithBody(json_encode($data, JSON_THROW_ON_ERROR), $httpStatusCode);

        return $response->withHeader('Content-Type', 'application/json');
    }
}

<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface as RPCResponseFactory;

/**
 * @author Philipp Marien
 */
abstract class AbstractResponseFactory implements RPCResponseFactory
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
     * @param int $httpStatusCode
     * @return ResponseInterface
     */
    protected function createHttpResponse($httpStatusCode = 200): ResponseInterface
    {
        return $this->responseFactory->createResponse($httpStatusCode);
    }

    /**
     * @param string $body
     * @param string $contentType
     * @param int $httpStatusCode
     * @return ResponseInterface
     */
    protected function createHttpResponseWithBody(
        string $body,
        string $contentType,
        int $httpStatusCode = 200
    ): ResponseInterface {
        return $this->createHttpResponse($httpStatusCode)
            ->withBody($this->streamFactory->createStream($body))
            ->withHeader('Content-Type', $contentType);
    }
}

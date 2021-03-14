<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;

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
}

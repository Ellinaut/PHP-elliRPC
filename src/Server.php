<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ExceptionResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ExceptionResponse;
use Ellinaut\ElliRPC\Event\RequestParsed;
use Ellinaut\ElliRPC\Exception\MissingRequestException;
use Ellinaut\ElliRPC\Exception\MissingResponseException;
use Ellinaut\ElliRPC\RequestParser\RequestParserInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class Server
{
    /**
     * @var EventDispatcherInterface
     */
    private EventDispatcherInterface $eventDispatcher;

    /**
     * @var RequestParserInterface
     */
    private RequestParserInterface $requestParser;

    /**
     * @var RequestProcessorInterface
     */
    private RequestProcessorInterface $requestProcessor;

    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param RequestParserInterface $requestParser
     * @param RequestProcessorInterface $requestProcessor
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        RequestParserInterface $requestParser,
        RequestProcessorInterface $requestProcessor,
        ResponseFactoryInterface $responseFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->requestParser = $requestParser;
        $this->requestProcessor = $requestProcessor;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        $contentType = 'json';

        try {
            $rpcRequest = $this->requestParser->parseRequest($request);
            if (!$rpcRequest) {
                throw new MissingRequestException();
            }
            $contentType = $rpcRequest->getRequestedContentType();

            $this->eventDispatcher->dispatch(new RequestParsed($rpcRequest));

            $response = $this->requestProcessor->processRequest($rpcRequest);

            if (!$response) {
                throw new MissingResponseException();
            }

            return $response;
        } catch (Throwable $throwable) {
            return $this->responseFactory->createResponse(
                new ExceptionResponse(
                    new ExceptionResponseContext($contentType),
                    $throwable
                )
            );
        }
    }
}

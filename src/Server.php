<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ExceptionContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ExceptionResponse;
use Ellinaut\ElliRPC\Event\RequestParsed;
use Ellinaut\ElliRPC\Exception\MissingRequestException;
use Ellinaut\ElliRPC\Exception\MissingResponseException;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Ellinaut\ElliRPC\RequestParser\RequestParserInterface;
use Ellinaut\ElliRPC\RequestProcessor\RequestProcessorInterface;
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
        try {
            $rpcRequest = $this->requestParser->parseRequest($request);
            if (!$rpcRequest) {
                throw new MissingRequestException();
            }

            $contentType = $rpcRequest->getContext()->getContentTypeExtension();

            if (!$this->responseFactory->supports($rpcRequest->getContext())) {
                throw new UnsupportedResponseException();
            }

            $this->eventDispatcher->dispatch(new RequestParsed($rpcRequest));

            $response = $this->requestProcessor->process($rpcRequest);
            if (!$response) {
                throw new MissingResponseException();
            }
        } catch (Throwable $throwable) {
            $response = new ExceptionResponse(
                new ExceptionContext(
                    $contentType ?? 'json',
                    $request->getHeader('Accept')
                ),
                $throwable
            );
        }

        return $this->responseFactory->createResponse($response);
    }
}

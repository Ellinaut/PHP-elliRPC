<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ExceptionContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ExceptionResponse;
use Ellinaut\ElliRPC\Event\RequestParsed;
use Ellinaut\ElliRPC\Exception\MissingRequestException;
use Ellinaut\ElliRPC\Exception\MissingResponseException;
use Ellinaut\ElliRPC\Exception\StatusProvidingExceptionInterface;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Ellinaut\ElliRPC\RequestParser\RequestParserInterface;
use Ellinaut\ElliRPC\RequestProcessor\RequestProcessorInterface;
use Ellinaut\ElliRPC\ResponseFactory\ExceptionMapperTrait;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface as PsrResponseFactory;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class Server
{
    use ExceptionMapperTrait;

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
     * @var PsrResponseFactory
     */
    private PsrResponseFactory $psrResponseFactory;

    /**
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param RequestParserInterface $requestParser
     * @param RequestProcessorInterface $requestProcessor
     * @param ResponseFactoryInterface $responseFactory
     * @param PsrResponseFactory $psrResponseFactory
     * @param StreamFactoryInterface $streamFactory
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        RequestParserInterface $requestParser,
        RequestProcessorInterface $requestProcessor,
        ResponseFactoryInterface $responseFactory,
        PsrResponseFactory $psrResponseFactory,
        StreamFactoryInterface $streamFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->requestParser = $requestParser;
        $this->requestProcessor = $requestProcessor;
        $this->responseFactory = $responseFactory;
        $this->psrResponseFactory = $psrResponseFactory;
        $this->streamFactory = $streamFactory;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
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

        try {
            return $this->responseFactory->createResponse($response);
        } catch (Throwable $throwable) {
            if ($response instanceof ExceptionResponse) {
                $throwable = $response->getException();
            }

            return $this->createFallbackErrorResponse($throwable);
        }
    }

    /**
     * @param Throwable $throwable
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function createFallbackErrorResponse(Throwable $throwable): ResponseInterface
    {
        $httpStatusCode = 500;
        if ($throwable instanceof StatusProvidingExceptionInterface) {
            $httpStatusCode = $throwable->getHttpStatusCode();
        }

        return $this->psrResponseFactory->createResponse($httpStatusCode)
            ->withBody($this->streamFactory->createStream(
                json_encode(
                    $this->mapException($throwable),
                    JSON_THROW_ON_ERROR
                )
            ))
            ->withHeader('Content-Type', 'application/json');
    }
}

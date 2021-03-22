<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Event\RequestParsed;
use Ellinaut\ElliRPC\Exception\MissingRequestException;
use Ellinaut\ElliRPC\Exception\MissingResponseException;
use Ellinaut\ElliRPC\RequestParser\RequestParserInterface;
use Ellinaut\ElliRPC\Processor\ExceptionProcessorInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
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
     * @var ExceptionProcessorInterface
     */
    private ExceptionProcessorInterface $exceptionProcessor;

    /**
     * @param EventDispatcherInterface $eventDispatcher
     * @param RequestParserInterface $requestParser
     * @param RequestProcessorInterface $requestProcessor
     * @param ExceptionProcessorInterface $exceptionProcessor
     */
    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        RequestParserInterface $requestParser,
        RequestProcessorInterface $requestProcessor,
        ExceptionProcessorInterface $exceptionProcessor
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->requestParser = $requestParser;
        $this->requestProcessor = $requestProcessor;
        $this->exceptionProcessor = $exceptionProcessor;
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

            $this->eventDispatcher->dispatch(new RequestParsed($rpcRequest));

            $response = $this->requestProcessor->processRequest($rpcRequest);

            if (!$response) {
                throw new MissingResponseException();
            }

            return $response;
        } catch (Throwable $throwable) {
            return $this->exceptionProcessor->processException($throwable);
        }
    }
}

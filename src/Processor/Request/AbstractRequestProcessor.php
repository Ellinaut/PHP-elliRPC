<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Ellinaut\ElliRPC\Exception\UnsupportedContentTypeException;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
abstract class AbstractRequestProcessor implements RequestProcessorInterface
{
    /**
     * @var ResponseFactoryInterface
     */
    private ResponseFactoryInterface $responseFactory;

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function __construct(ResponseFactoryInterface $responseFactory)
    {
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param ResponseContext $responseContext
     * @throws UnsupportedContentTypeException
     */
    protected function throwExceptionOnUnsupportedResponseFormat(ResponseContext $responseContext): void
    {
        if (!$this->responseFactory->supports($responseContext)) {
            throw new UnsupportedContentTypeException($responseContext->getContentType());
        }
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    protected function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        return $this->responseFactory->createResponse($formatableResponse);
    }
}

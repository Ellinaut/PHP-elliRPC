<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Ellinaut\ElliRPC\Exception\UnsupportedContentTypeException;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
class ResponseFactoryRegistry implements ResponseFactoryInterface
{
    /**
     * @var ResponseFactoryInterface[]
     */
    private array $responseFactories = [];

    /**
     * @param ResponseFactoryInterface $responseFactory
     */
    public function register(ResponseFactoryInterface $responseFactory): void
    {
        $this->responseFactories[] = $responseFactory;
    }

    /**
     * @param ResponseContext $context
     * @return bool
     */
    public function supports(ResponseContext $context): bool
    {
        foreach ($this->responseFactories as $responseFactory) {
            if ($responseFactory->supports($context)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        foreach ($this->responseFactories as $responseFactory) {
            if ($responseFactory->supports($formatableResponse->getContext())) {
                return $responseFactory->createResponse($formatableResponse);
            }
        }

        throw new UnsupportedContentTypeException($formatableResponse->getContext()->getContentType());
    }
}

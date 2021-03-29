<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
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
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool
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

        throw new UnsupportedContentTypeException($formatableResponse->getContext()->getContentTypeExtension());
    }
}

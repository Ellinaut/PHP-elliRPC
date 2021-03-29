<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ExceptionContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\ExceptionResponse;
use Ellinaut\ElliRPC\Exception\StatusProvidingExceptionInterface;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ExceptionJsonResponseFactory extends AbstractResponseFactory
{
    use ExceptionMapperTrait;

    /**
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool
    {
        return $context instanceof ExceptionContext && $context->getContentTypeExtension() === 'json';
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if (!$formatableResponse instanceof ExceptionResponse || !$this->supports($formatableResponse->getContext())) {
            throw new UnsupportedResponseException();
        }

        $exception = $formatableResponse->getException();

        $httpStatusCode = 500;
        if ($exception instanceof StatusProvidingExceptionInterface) {
            $httpStatusCode = $exception->getHttpStatusCode();
        }

        return $this->createHttpResponseWithBody(
            json_encode(
                $this->mapException($exception),
                JSON_THROW_ON_ERROR
            ),
            'application/json',
            $httpStatusCode
        );
    }
}

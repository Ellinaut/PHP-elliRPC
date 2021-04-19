<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\FileContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\FileReferenceContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileDeletedResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileReferenceResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileResponseFactory extends AbstractResponseFactory
{
    /**
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool
    {
        return $context instanceof FileContext || $context instanceof FileReferenceContext;
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if ($formatableResponse instanceof FileResponse) {
            return $this->createHttpResponseWithBody(
                $formatableResponse->getContent()->getContent(),
                $formatableResponse->getContent()->getMimeType()
            );
        }

        if ($formatableResponse instanceof FileReferenceResponse) {
            return $this->createHttpResponseWithBody(null, 'text/plain', 201)
                ->withHeader(
                    'Content-Location',
                    $formatableResponse->getContent()->getPublicLocation()
                );
        }

        if ($formatableResponse instanceof FileDeletedResponse) {
            return $this->createHttpResponseWithBody(null, 'Content-Location', 204);
        }

        throw new UnsupportedResponseException();
    }
}

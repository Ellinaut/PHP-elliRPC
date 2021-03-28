<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileDeletedResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\FileResponseContext;
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
     * @param AbstractResponseContext $context
     * @return bool
     */
    public function supports(AbstractResponseContext $context): bool
    {
        return $context instanceof FileResponseContext;
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
                    $formatableResponse->getContent()->getContentLocationValue()
                );
        }

        if ($formatableResponse instanceof FileDeletedResponse) {
            return $this->createHttpResponseWithBody(null, 'Content-Location', 204);
        }

        throw new UnsupportedResponseException();
    }
}

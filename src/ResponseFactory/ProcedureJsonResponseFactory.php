<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ProcedureResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param ResponseContext $context
     * @return bool
     */
    public function supports(ResponseContext $context): bool
    {
        if (!$context instanceof ProcedureResponseContext) {
            return false;
        }

        return $context->getContentType() === 'json';
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if (!$formatableResponse instanceof ProcedureResponse) {
            throw new UnsupportedResponseException();
        }

        return $this->createHttpResponseWithBody(
            json_encode($formatableResponse->getContent()->getData(), JSON_THROW_ON_ERROR),
            'application/json'
        );
    }
}

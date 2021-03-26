<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ProcedureResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param AbstractResponseContext $context
     * @return bool
     */
    public function supports(AbstractResponseContext $context): bool
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

        $httpStatusCode = 200;
        $data = $formatableResponse->getContent()->getData();
        //@todo map error and change status code if $formatableResponse->getContent()->getException() !== null

        $content = '';
        if (is_array($data)) {
            $content = json_encode($data, JSON_THROW_ON_ERROR);
        }
        //@todo accepted or no content status for empty content

        return $this->createHttpResponseWithBody($content, 'application/json', $httpStatusCode);
    }
}

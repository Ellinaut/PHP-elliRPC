<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ProcedureExecutionContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureExecutionResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool
    {
        if (!$context instanceof ProcedureExecutionContext) {
            return false;
        }

        return $context->getContentTypeExtension() === 'json';
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     * @throws Throwable
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if (!$formatableResponse instanceof ProcedureExecutionResponse) {
            throw new UnsupportedResponseException();
        }

        $data = $formatableResponse->getContent();

        $content = '';
        if (is_array($data)) {
            $content = json_encode($data, JSON_THROW_ON_ERROR);
        }

        return $this->createHttpResponseWithBody(
            $content,
            'application/json',
            empty($content) ? 204 : 200
        );
    }
}

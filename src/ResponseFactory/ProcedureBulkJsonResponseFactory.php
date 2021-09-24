<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ProcedureExecutionBulkContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\TransactionExecutionContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureExecutionBulkResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\TransactionExecutionResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureBulkJsonResponseFactory extends AbstractResponseFactory
{
    use ExceptionMapperTrait;

    /**
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool
    {
        if (!$context instanceof TransactionExecutionContext && !$context instanceof ProcedureExecutionBulkContext) {
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
        if (!$formatableResponse instanceof TransactionExecutionResponse && !$formatableResponse instanceof ProcedureExecutionBulkResponse) {
            throw new UnsupportedResponseException();
        }

        $procedures = [];
        foreach ($formatableResponse->getContent() as $executionResult) {
            $result = null;
            $successful = true;
            if ($executionResult->getData()) {
                $result = $executionResult->getData();
            }
            if ($executionResult->getException()) {
                $successful = false;
                $result = $this->mapException($executionResult->getException());
            }

            $procedures[] = [
                'package' => $executionResult->getDefinition()->getPackageName(),
                'procedure' => $executionResult->getDefinition()->getProcedureName(),
                'successful' => $successful,
                'result' => $result,
            ];
        }

        return $this->createHttpResponseWithBody(
            json_encode(['procedures' => $procedures], JSON_THROW_ON_ERROR),
            'application/json'
        );
    }
}

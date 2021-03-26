<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\TransactionsResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\TransactionsResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class TransactionExecutionsJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param AbstractResponseContext $context
     * @return bool
     */
    public function supports(AbstractResponseContext $context): bool
    {
        if (!$context instanceof TransactionsResponseContext) {
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
        if (!$formatableResponse instanceof TransactionsResponse) {
            throw new UnsupportedResponseException();
        }

        $formattedTransactions = [];
        foreach ($formatableResponse->getContent() as $transactionResult) {
            $formattedResults = [];
            foreach ($transactionResult->getProcedureResults() as $procedureResult) {
                $formattedResults = [
                    'package' => $procedureResult->getProcedure()->getPackageName(),
                    'procedure' => $procedureResult->getProcedure()->getProcedureName(),
                    'successful' => $procedureResult->isSuccessful(),
                    'result' => $procedureResult->getData(),//@todo map error if not successful
                ];
            }
            $formattedTransactions[$transactionResult->getTransactionId()] = [
                'successful' => $transactionResult->isSuccessful(),
                'procedureResults' => $formattedResults,
                'error' => null//@todo map exception
            ];
        }

        return $this->createHttpResponseWithBody(
            json_encode(['transactions' => $formattedTransactions], JSON_THROW_ON_ERROR),
            'application/json'
        );
    }
}

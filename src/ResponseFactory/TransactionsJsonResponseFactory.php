<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\TransactionsResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\TransactionsResponse;
use Ellinaut\ElliRPC\Exception\UnsupportedResponseException;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
class TransactionsJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param ResponseContext $context
     * @return bool
     */
    public function supports(ResponseContext $context): bool
    {
        if (!$context instanceof TransactionsResponseContext) {
            return false;
        }

        return $context->getContentType() === 'json';
    }

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface
    {
        if (!$formatableResponse instanceof TransactionsResponse) {
            throw new UnsupportedResponseException();
        }
        //@todo

        //        $data = [];
//        foreach ($transactions as $transactionId => $procedureResults) {
//            $formattedResults = [];
//            foreach ($procedureResults as $procedureResult) {
//                $formattedResults = [
//                    'package' => $procedureResult->getProcedure()->getPackageName(),
//                    'procedure' => $procedureResult->getProcedure()->getProcedureName(),
//                    'status' => $procedureResult->getStatus(),
//                    'response' => $procedureResult->getData(),
//                ];
//            }
//
//            $data[$transactionId] = [
//                'results' => $formattedResults,
//                'successful' => $this->isTransactionSuccessful($procedureResults)
//            ];
//        }

//        return $this->createResponseWithBody(
//            json_encode(['transactions' => $data], JSON_THROW_ON_ERROR),
//            'application/json'
//        );
    }
}

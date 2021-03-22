<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\TransactionsExecutionRequest;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 * @todo move responses to response factory
 */
class TransactionExecutionProcessor extends AbstractExecutionProcessor
{
    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if (!$request instanceof TransactionsExecutionRequest) {
            throw new InvalidRequestProcessorException();
        }

        $transactions = [];
        foreach ($request->getTransactions() as $transactionId => $procedures) {
            $this->startTransaction($transactionId);

            $procedureResults = [];
            foreach ($procedures as $procedure) {
                $procedureResults[] = $this->executeProcedure(
                    $transactionId,
                    new Procedure(
                        $procedure['package'],
                        $procedure['procedure'],
                        $procedure['data'],
                        $procedure['pagination'],
                        $procedure['sorting']
                    )
                );
            }

            $this->finishTransaction(
                $transactionId,
                $this->isTransactionSuccessful($procedureResults)
            );

            $transactions[$transactionId] = $procedureResults;
        }

        $data = [];
        foreach ($transactions as $transactionId => $procedureResults) {
            $formattedResults = [];
            foreach ($procedureResults as $procedureResult) {
                $formattedResults = [
                    'package' => $procedureResult->getProcedure()->getPackageName(),
                    'procedure' => $procedureResult->getProcedure()->getProcedureName(),
                    'status' => $procedureResult->getStatus(),
                    'response' => $procedureResult->getData(),
                ];
            }

            $data[$transactionId] = [
                'results' => $formattedResults,
                'successful' => $this->isTransactionSuccessful($procedureResults)
            ];
        }

        return $this->createResponseWithBody(
            json_encode(['transactions' => $data], JSON_THROW_ON_ERROR),
            'application/json'
        );
    }
}

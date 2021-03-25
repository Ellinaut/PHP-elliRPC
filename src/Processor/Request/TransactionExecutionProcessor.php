<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\TransactionsResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\TransactionsResponse;
use Ellinaut\ElliRPC\DataTransfer\Workflow\Procedure;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\TransactionsExecutionRequest;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
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

        $responseContext = new TransactionsResponseContext($request->getRequestedContentType());
        $this->throwExceptionOnUnsupportedResponseFormat($responseContext);

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

        return $this->createResponse(
            new TransactionsResponse(
                $responseContext,
                $transactions
            )
        );
    }
}

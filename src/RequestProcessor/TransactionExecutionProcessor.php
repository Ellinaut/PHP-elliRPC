<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\ExecutionResult;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\TransactionExecutionRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\TransactionExecutionResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Throwable;

/**
 * @author Philipp Marien
 */
class TransactionExecutionProcessor extends AbstractProcedureExecutionProcessor
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     * @throws Throwable
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if (!$request instanceof TransactionExecutionRequest) {
            throw new InvalidRequestProcessorException();
        }

        $transactionId = $this->generateTransactionId();
        $this->startTransaction($transactionId);

        try {
            $executionResults = [];
            foreach ($request->getProcedures() as $procedure) {
                try {
                    $executionResults[] = new ExecutionResult(
                        $procedure->getDefinition(),
                        $this->getProcessor()->process($transactionId, $procedure),
                        null
                    );
                } catch (Throwable $exception) {
                    $executionResults[] = new ExecutionResult(
                        $procedure->getDefinition(),
                        null,
                        $exception
                    );
                }
            }

            $this->finishTransaction($transactionId);

            return new TransactionExecutionResponse($request->getContext(), $executionResults);
        } catch (Throwable $exception) {
            $this->failTransaction($transactionId);

            throw $exception;
        }
    }
}

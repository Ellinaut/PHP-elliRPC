<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\ExecutionResult;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\ProcedureExecutionBulkRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureExecutionBulkResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionBulkProcessor extends AbstractProcedureExecutionProcessor
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if (!$request instanceof ProcedureExecutionBulkRequest) {
            throw new InvalidRequestProcessorException();
        }

        $executionResults = [];
        foreach ($request->getProcedures() as $procedure) {
            $transactionId = $this->generateTransactionId();

            try {
                $this->startTransaction($transactionId);

                $procedureResultBody = $this->getProcessor()->process($transactionId, $procedure);

                $executionResults[] = new ExecutionResult($procedure->getDefinition(), $procedureResultBody, null);

                $this->finishTransaction($transactionId);
            } catch (Throwable $exception) {
                $this->failTransaction($transactionId);

                $executionResults[] = new ExecutionResult(
                    $procedure->getDefinition(),
                    null,
                    $exception
                );
            }
        }

        return new ProcedureExecutionBulkResponse($request->getContext(), $executionResults);
    }
}

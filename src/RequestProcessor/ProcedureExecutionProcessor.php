<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\ProcedureExecutionRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\ProcedureExecutionResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionProcessor extends AbstractProcedureExecutionProcessor
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     * @throws Throwable
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if (!$request instanceof ProcedureExecutionRequest) {
            throw new InvalidRequestProcessorException();
        }

        $transactionId = $this->generateTransactionId();

        try {
            $this->startTransaction($transactionId);

            $procedureResult = $this->getProcessor()->process($transactionId, $request->getProcedure());

            $this->finishTransaction($transactionId);

            return new ProcedureExecutionResponse($request->getContext(), $procedureResult);
        } catch (Throwable $exception) {
            $this->failTransaction($transactionId);

            throw $exception;
        }
    }
}

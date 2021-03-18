<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\ProcedureResult;
use Ellinaut\ElliRPC\Request\ProcedureExecutionRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface ProcedureExecutionResponseFactoryInterface
{
    /**
     * @param ProcedureExecutionRequest $request
     * @param ProcedureResult $result
     * @return ResponseInterface
     */
    public function createResponse(ProcedureExecutionRequest $request, ProcedureResult $result): ResponseInterface;
}

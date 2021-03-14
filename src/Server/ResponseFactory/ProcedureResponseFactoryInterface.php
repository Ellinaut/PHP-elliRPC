<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use Ellinaut\ElliRPC\Server\Value\ProcedureResult;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface ProcedureResponseFactoryInterface
{
    /**
     * @param ProcedureResult $procedureResult
     * @return ResponseInterface
     */
    public function createResponse(ProcedureResult $procedureResult): ResponseInterface;
}

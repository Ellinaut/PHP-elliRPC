<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ProcedureExecutionBulkContext;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\ProcedureExecutionBulkRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionBulkRequestParser extends AbstractBulkRequestParser
{
    /**
     * @return string
     */
    protected function getPath(): string
    {
        return '@procedures/executeBulk';
    }

    /**
     * @param array $procedures
     * @param RequestInterface $request
     * @return AbstractRequest
     */
    protected function createRequest(array $procedures, RequestInterface $request): AbstractRequest
    {
        return new ProcedureExecutionBulkRequest(
            new ProcedureExecutionBulkContext(
                'json',
                $request->getHeader('Accept')
            ),
            $procedures,
            $request->getHeaders()
        );
    }
}

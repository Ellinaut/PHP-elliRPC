<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\TransactionExecutionContext;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\TransactionExecutionRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class TransactionsExecutionRequestParser extends AbstractBulkRequestParser
{
    /**
     * @return string
     */
    protected function getPath(): string
    {
        return '@transactions/execute';
    }

    /**
     * @param array $procedures
     * @param RequestInterface $request
     * @return AbstractRequest
     */
    protected function createRequest(array $procedures, RequestInterface $request): AbstractRequest
    {
        return new TransactionExecutionRequest(
            new TransactionExecutionContext(
                'json',
                $request->getHeader('Accept')
            ),
            $procedures,
            $request->getHeaders()
        );
    }
}

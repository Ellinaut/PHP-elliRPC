<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use Ellinaut\ElliRPC\Server\Value\TransactionResult;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface TransactionResponseFactoryInterface
{
    /**
     * @param TransactionResult $transactionResult
     * @return ResponseInterface
     */
    public function createResponse(TransactionResult $transactionResult): ResponseInterface;
}

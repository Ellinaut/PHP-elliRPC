<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
interface ThrowableResponseFactoryInterface
{
    /**
     * @param Throwable $throwable
     * @return ResponseInterface
     */
    public function createResponse(Throwable $throwable): ResponseInterface;
}

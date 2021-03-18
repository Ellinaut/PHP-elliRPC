<?php

namespace Ellinaut\ElliRPC\Processor;

use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
interface ExceptionProcessorInterface
{
    /**
     * @param Throwable $throwable
     * @return ResponseInterface
     */
    public function processException(Throwable $throwable): ResponseInterface;
}

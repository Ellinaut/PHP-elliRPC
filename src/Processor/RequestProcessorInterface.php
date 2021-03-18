<?php

namespace Ellinaut\ElliRPC\Processor;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface RequestProcessorInterface
{
    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     */
    public function processRequest(AbstractRequest $request): ResponseInterface;
}

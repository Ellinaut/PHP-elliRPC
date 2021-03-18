<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
interface RequestParserInterface
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest;
}

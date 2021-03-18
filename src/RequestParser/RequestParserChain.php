<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class RequestParserChain implements RequestParserInterface
{
    /**
     * @var RequestParserInterface[][]
     */
    private array $parsers = [];

    /**
     * @param RequestParserInterface $requestParser
     * @param int $priority
     */
    public function addRequestParser(RequestParserInterface $requestParser, int $priority = 5): void
    {
        $this->parsers[$priority][] = $requestParser;
    }

    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        krsort($this->parsers); // highest priority first

        foreach ($this->parsers as $parsers) {
            foreach ($parsers as $parser) {
                $rpcRequest = $parser->parseRequest($request);
                if ($rpcRequest) {
                    return $rpcRequest;
                }
            }
        }

        return null;
    }
}

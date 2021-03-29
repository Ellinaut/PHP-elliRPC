<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

/**
 * @author Philipp Marien
 */
abstract class AbstractRequest
{
    /**
     * @var AbstractFormattingContext
     */
    private AbstractFormattingContext $context;

    /**
     * @var string[][]
     */
    private array $requestHeaders = [];

    /**
     * @param AbstractFormattingContext $context
     * @param string[][] $requestHeaders
     */
    public function __construct(AbstractFormattingContext $context, array $requestHeaders = [])
    {
        $this->context = $context;

        foreach ($requestHeaders as $requestHeader => $values) {
            $this->requestHeaders[strtolower($requestHeader)] = $values;
        }
    }

    /**
     * @return AbstractFormattingContext
     */
    public function getContext(): AbstractFormattingContext
    {
        return $this->context;
    }

    /**
     * @param string $header
     * @return array|string[]
     */
    public function getHeaderValues(string $header): array
    {
        $header = strtolower($header);
        if (!array_key_exists($header, $this->requestHeaders)) {
            return [];
        }

        return $this->requestHeaders[$header];
    }

    /**
     * @param string $header
     * @return string|null
     */
    public function getHeaderValue(string $header): ?string
    {
        $values = $this->getHeaderValues($header);

        return count($values) > 0 ? $values[0] : null;
    }
}

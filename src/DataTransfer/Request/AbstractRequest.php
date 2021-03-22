<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

/**
 * @author Philipp Marien
 */
abstract class AbstractRequest
{
    /**
     * @var string[][]
     */
    private array $headers = [];

    /**
     * @var string
     */
    private string $requestedContentType;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     */
    public function __construct(array $headers, string $requestedContentType)
    {
        foreach ($headers as $header => $values) {
            $this->headers[strtolower($header)] = $values;
        }

        $this->requestedContentType = $requestedContentType;
    }

    /**
     * @param string $header
     * @return array|string[]
     */
    public function getHeaderValues(string $header): array
    {
        $header = strtolower($header);
        if (!array_key_exists($header, $this->headers)) {
            return [];
        }

        return $this->headers[$header];
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

    /**
     * @return string
     */
    public function getRequestedContentType(): string
    {
        return $this->requestedContentType;
    }
}

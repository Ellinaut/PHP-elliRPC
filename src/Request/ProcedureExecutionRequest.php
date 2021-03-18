<?php

namespace Ellinaut\ElliRPC\Request;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private string $packageName;

    /**
     * @var string
     */
    private string $procedureName;

    /**
     * @var array
     */
    private array $query;

    /**
     * @var string|null
     */
    private ?string $body;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param string $packageName
     * @param string $procedureName
     * @param array $query
     * @param string|null $body
     */
    public function __construct(
        array $headers,
        string $requestedContentType,
        string $packageName,
        string $procedureName,
        array $query,
        ?string $body
    ) {
        parent::__construct($headers, $requestedContentType);
        $this->packageName = $packageName;
        $this->procedureName = $procedureName;
        $this->query = $query;
        $this->body = $body;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @return string
     */
    public function getProcedureName(): string
    {
        return $this->procedureName;
    }

    /**
     * @return array
     */
    public function getQuery(): array
    {
        return $this->query;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }
}

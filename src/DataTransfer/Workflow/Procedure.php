<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

/**
 * @author Philipp Marien
 */
class Procedure
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
    private array $requestData;

    /**
     * @var array
     */
    private array $pagination;

    /**
     * @var string|null
     */
    private ?string $sorting;

    /**
     * @param string $packageName
     * @param string $procedureName
     * @param array $requestData
     * @param array $pagination
     * @param string|null $sorting
     */
    public function __construct(
        string $packageName,
        string $procedureName,
        array $requestData,
        array $pagination,
        ?string $sorting
    ) {
        $this->packageName = $packageName;
        $this->procedureName = $procedureName;
        $this->requestData = $requestData;
        $this->pagination = $pagination;
        $this->sorting = $sorting;
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
    public function getRequestData(): array
    {
        return $this->requestData;
    }

    /**
     * @return array
     */
    public function getPagination(): array
    {
        return $this->pagination;
    }

    /**
     * @return string|null
     */
    public function getSorting(): ?string
    {
        return $this->sorting;
    }
}

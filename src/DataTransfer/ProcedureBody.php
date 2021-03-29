<?php

namespace Ellinaut\ElliRPC\DataTransfer;

/**
 * @author Philipp Marien
 */
class ProcedureBody
{
    /**
     * @var array|null
     */
    private ?array $paginateBy;

    /**
     * @var string|null
     */
    private ?string $sortBy;

    /**
     * @var array|null
     */
    private ?array $data;

    /**
     * @param array|null $paginateBy
     * @param string|null $sortBy
     * @param array|null $data
     */
    public function __construct(?array $paginateBy, ?string $sortBy, ?array $data)
    {
        $this->paginateBy = $paginateBy;
        $this->sortBy = $sortBy;
        $this->data = $data;
    }

    /**
     * @return array|null
     */
    public function getPaginateBy(): ?array
    {
        return $this->paginateBy;
    }

    /**
     * @return string|null
     */
    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }
}

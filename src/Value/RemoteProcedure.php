<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
class RemoteProcedure
{
    public function __construct(
        private readonly string $package,
        private readonly string $procedure,
        private readonly ?array $data,
        private readonly ?array $meta
    ) {
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->package;
    }

    /**
     * @return string
     */
    public function getProcedureName(): string
    {
        return $this->procedure;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return array|null
     */
    public function getMeta(): ?array
    {
        return $this->meta;
    }
}

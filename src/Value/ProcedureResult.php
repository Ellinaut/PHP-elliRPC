<?php

namespace Ellinaut\ElliRPC\Value;

use JsonSerializable;

/**
 * @author Philipp Marien
 */
class ProcedureResult implements JsonSerializable
{
    /**
     * @param Error[] $errors
     */
    public function __construct(
        private readonly bool $success,
        protected ?JsonSerializable $data = null,
        protected ?JsonSerializable $meta = null,
        protected array $errors = [],
    ) {
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @return JsonSerializable|null
     */
    public function getData(): ?JsonSerializable
    {
        return $this->data;
    }

    /**
     * @return JsonSerializable|null
     */
    public function getMeta(): ?JsonSerializable
    {
        return $this->meta;
    }

    /**
     * @return Error[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'success' => $this->isSuccess(),
            'data' => $this->getData(),
            'meta' => $this->getMeta(),
            'errors' => $this->getErrors()
        ];
    }

}

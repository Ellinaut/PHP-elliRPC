<?php

namespace Ellinaut\ElliRPC\Error;

use JsonSerializable;

/**
 * @author Philipp Marien
 */
class Error implements JsonSerializable
{
    public function __construct(
        protected array $message,
        private readonly string $code,
        private readonly ?string $source = null,
        private readonly ?JsonSerializable $context = null
    ) {
    }

    /**
     * @return array
     */
    public function getMessage(): array
    {
        return $this->message;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @return string|null
     */
    public function getSource(): ?string
    {
        return $this->source;
    }

    /**
     * @return JsonSerializable|null
     */
    public function getContext(): ?JsonSerializable
    {
        return $this->context;
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return [
            'message' => $this->getMessage(),
            'code' => $this->getCode(),
            'source' => $this->getSource(),
            'context' => $this->getContext()
        ];
    }
}

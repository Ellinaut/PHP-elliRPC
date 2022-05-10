<?php

namespace Ellinaut\ElliRPC\Error;

use JsonSerializable;

/**
 * @author Philipp Marien
 */
class TranslateableHttpError extends TranslateableError implements HttpErrorInterface
{
    public function __construct(
        private int $statusCode,
        string $defaultLanguage,
        string $defaultMessage,
        string $code,
        ?string $source = null,
        ?JsonSerializable $context = null
    ) {
        parent::__construct($defaultLanguage, $defaultMessage, $code, $source, $context);
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}

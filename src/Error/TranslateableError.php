<?php

namespace Ellinaut\ElliRPC\Error;

use JsonSerializable;

/**
 * @author Philipp Marien
 */
class TranslateableError extends Error
{
    public function __construct(
        private readonly string $defaultLanguage,
        private readonly string $defaultMessage,
        string $code,
        ?string $source = null,
        ?JsonSerializable $context = null
    ) {
        parent::__construct(
            [
                $this->defaultLanguage => $this->defaultMessage
            ],
            $code,
            $source,
            $context
        );
    }

    /**
     * @return string
     */
    public function getDefaultLanguage(): string
    {
        return $this->defaultLanguage;
    }

    /**
     * @return string
     */
    public function getDefaultMessage(): string
    {
        return $this->defaultMessage;
    }

    /**
     * @param string $language
     * @param string $message
     * @return void
     */
    public function addTranslation(string $language, string $message): void
    {
        $this->message[$language] = $message;
    }
}

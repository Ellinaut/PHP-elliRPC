<?php

namespace Ellinaut\ElliRPC\Error\Translator;

use Ellinaut\ElliRPC\Error\TranslateableError;

/**
 * @author Philipp Marien
 */
class ErrorTranslatorChain implements ErrorTranslatorInterface
{
    /**
     * @var ErrorTranslatorInterface[]
     */
    private array $translators = [];

    public function register(ErrorTranslatorInterface $translator): void
    {
        $this->translators[] = $translator;
    }

    /**
     * @param TranslateableError $error
     * @return void
     */
    public function translate(TranslateableError $error): void
    {
        foreach ($this->translators as $translator) {
            $translator->translate($error);
        }
    }
}

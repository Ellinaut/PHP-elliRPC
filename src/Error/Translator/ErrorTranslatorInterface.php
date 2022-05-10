<?php

namespace Ellinaut\ElliRPC\Error\Translator;

use Ellinaut\ElliRPC\Error\TranslateableError;

/**
 * @author Philipp Marien
 */
interface ErrorTranslatorInterface
{
    public function translate(TranslateableError $error): void;
}

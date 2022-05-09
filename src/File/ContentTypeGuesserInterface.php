<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
interface ContentTypeGuesserInterface
{
    public function guessContentType(string $filePath): string;
}

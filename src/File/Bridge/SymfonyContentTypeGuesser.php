<?php

namespace Ellinaut\ElliRPC\File\Bridge;

use Ellinaut\ElliRPC\File\ContentTypeGuesserInterface;
use Symfony\Component\Mime\MimeTypeGuesserInterface;

/**
 * @author Philipp Marien
 */
class SymfonyContentTypeGuesser implements ContentTypeGuesserInterface
{
    public function __construct(
        private readonly MimeTypeGuesserInterface $mimeTypeGuesser
    ) {
    }

    public function guessContentType(string $filePath): string
    {
        return $this->mimeTypeGuesser->guessMimeType($filePath) ?? 'text/plain';
    }
}

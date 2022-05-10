<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class FileNotFoundException extends FileException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.file_not_found';
    }
}

<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class UnsupportedFilesystemException extends FileException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.files.unsupported';
    }
}

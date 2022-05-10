<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class FileExistException extends FileException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.file_exist';
    }
}

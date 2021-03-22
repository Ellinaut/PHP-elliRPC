<?php

namespace Ellinaut\ElliRPC\Exception;

use RuntimeException;

/**
 * @author Philipp Marien
 */
class FileHandlerException extends RuntimeException
{
    /**
     * @param string $message
     */
    public function __construct(string $message)
    {
        parent::__construct($message, 20210322154610);
    }
}

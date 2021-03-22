<?php

namespace Ellinaut\ElliRPC\Exception;

use RuntimeException;

/**
 * @author Philipp Marien
 */
abstract class NotFoundException extends RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     */
    public function __construct(string $message, int $code)
    {
        parent::__construct($message, $code);
    }
}

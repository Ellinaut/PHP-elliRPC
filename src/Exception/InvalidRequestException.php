<?php

namespace Ellinaut\ElliRPC\Exception;

use InvalidArgumentException;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class InvalidRequestException extends InvalidArgumentException
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

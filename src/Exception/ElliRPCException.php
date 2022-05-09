<?php

namespace Ellinaut\ElliRPC\Exception;

use Exception;

/**
 * @author Philipp Marien
 */
abstract class ElliRPCException extends Exception
{
    abstract public function getErrorCode(): string;
}

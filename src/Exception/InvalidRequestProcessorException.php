<?php

namespace Ellinaut\ElliRPC\Exception;

use RuntimeException;

/**
 * @author Philipp Marien
 */
class InvalidRequestProcessorException extends RuntimeException
{
    public function __construct()
    {
        parent::__construct('The chosen processor isn\'t able to process the given request.', 20210322123433);
    }
}

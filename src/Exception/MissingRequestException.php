<?php

namespace Ellinaut\ElliRPC\Exception;

use Throwable;

/**
 * @author Philipp Marien
 */
class MissingRequestException extends InvalidRequestException
{
    public function __construct()
    {
        parent::__construct('There is no processor able to parse your request.', 20210322134353);
    }
}

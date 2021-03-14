<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class MissingContentTypeException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('', 20210314223426);
    }
}

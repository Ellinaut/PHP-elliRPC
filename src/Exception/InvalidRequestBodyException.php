<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class InvalidRequestBodyException extends InvalidRequestException
{
    public function __construct()
    {
        parent::__construct(
            'The request body contains invalid content which can not be processed.',
            20210329200846
        );
    }
}

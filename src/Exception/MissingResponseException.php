<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class MissingResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            'There is no processor able to create a response for your request.',
            20210322133813
        );
    }
}

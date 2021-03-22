<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class InvalidContentTypeHeaderException extends InvalidRequestException
{
    public function __construct()
    {
        parent::__construct(
            'The server could not determine a supported content type via content type header.',
            20210314223426
        );
    }
}

<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class EndpointNotFoundException extends NotFoundException
{
    public function __construct()
    {
        parent::__construct('The requested endpoint could not be found.', 20210326164439);
    }
}

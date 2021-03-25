<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class UnsupportedResponseException extends \Exception
{
    public function __construct()
    {
        parent::__construct(
            'The chosen response factory isn\'t able format your response for the client.',
            2021032513055
        );
    }
}

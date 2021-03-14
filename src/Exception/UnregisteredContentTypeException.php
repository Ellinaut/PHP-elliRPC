<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class UnregisteredContentTypeException extends \RuntimeException
{
    /**
     * @param string $contentType
     */
    public function __construct(string $contentType)
    {//@todo
        parent::__construct('', 20210312132637);
    }
}

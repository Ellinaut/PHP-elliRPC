<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class UnsupportedContentTypeException extends \RuntimeException
{
    /**
     * @param string $contentType
     */
    public function __construct(string $contentType)
    {
        parent::__construct('Unsupported content type: ' . $contentType, 20210314202921);
    }
}

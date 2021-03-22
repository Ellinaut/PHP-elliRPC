<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class UnsupportedContentTypeException extends InvalidRequestException
{
    /**
     * @param string $contentType
     */
    public function __construct(string $contentType)
    {
        parent::__construct(
            'The server isn\'t able to respond with content type "' . $contentType . '" to this request.',
            20210322171206
        );
    }
}

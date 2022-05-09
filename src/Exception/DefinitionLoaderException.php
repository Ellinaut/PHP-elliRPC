<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class DefinitionLoaderException extends ElliRPCException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.definition.loader';
    }
}

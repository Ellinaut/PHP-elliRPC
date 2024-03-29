<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class DefinitionException extends ElliRPCException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.definition.invalid';
    }
}

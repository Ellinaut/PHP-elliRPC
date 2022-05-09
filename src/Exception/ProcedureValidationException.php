<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class ProcedureValidationException extends ElliRPCException
{
    public function getErrorCode(): string
    {
        return 'elli.procedure.validation';
    }
}

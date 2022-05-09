<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class ProcedureException extends ElliRPCException
{
    /**
     * @return string
     */
    public function getErrorCode(): string
    {
        return 'elli.procedure.execution';
    }
}

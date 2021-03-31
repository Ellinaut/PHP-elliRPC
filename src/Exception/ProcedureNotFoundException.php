<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class ProcedureNotFoundException extends NotFoundException
{
    /**
     * @param string $package
     * @param string $procedure
     */
    public function __construct(string $package, string $procedure)
    {
        parent::__construct(
            'The server isn\'t able to find a procedure with name "' . $procedure . '" in the package "' . $package . '".',
            20210331132922
        );
    }
}

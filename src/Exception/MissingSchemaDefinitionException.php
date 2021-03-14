<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class MissingSchemaDefinitionException extends \RuntimeException
{
    /**
     * @param string $schemaName
     */
    public function __construct(string $schemaName)
    {//@todo
        parent::__construct('', 20210312134050);
    }
}

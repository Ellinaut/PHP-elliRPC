<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionNotFoundException extends NotFoundException
{
    /**
     * @param string $schemaName
     */
    public function __construct(string $schemaName)
    {
        parent::__construct(
            'The definition for schema "' . $schemaName . '" could not be found.',
            20210322140947
        );
    }
}

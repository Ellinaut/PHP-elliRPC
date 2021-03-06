<?php

namespace Ellinaut\ElliRPC\Server\Formatter;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionFormatterInterface
{

    /**
     * @param SchemaDefinitionInterface $schemaDefinition
     * @return string
     */
    public function format(SchemaDefinitionInterface $schemaDefinition): string;
}

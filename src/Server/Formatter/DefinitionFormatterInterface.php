<?php

namespace Ellinaut\ElliRPC\Server\Formatter;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface DefinitionFormatterInterface
{
    /**
     * @param PackageDefinitionInterface[] $packageDefinitions
     * @return string
     */
    public function formatPackages(array $packageDefinitions): string;

    /**
     * @param SchemaDefinitionInterface $schemaDefinition
     * @return string
     */
    public function formatSchema(SchemaDefinitionInterface $schemaDefinition): string;
}

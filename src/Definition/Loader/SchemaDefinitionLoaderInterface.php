<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionLoaderException;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionLoaderInterface
{
    /**
     * @param string $package
     * @param string $schema
     * @return SchemaDefinitionInterface
     * @throws DefinitionLoaderException
     */
    public function loadSchemaDefinition(string $package, string $schema): SchemaDefinitionInterface;
}

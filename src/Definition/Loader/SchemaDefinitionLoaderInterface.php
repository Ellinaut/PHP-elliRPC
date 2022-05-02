<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\LoaderException;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionLoaderInterface
{
    /**
     * @param string $package
     * @param string $schema
     * @return SchemaDefinitionInterface
     * @throws LoaderException
     */
    public function loadSchemaDefinition(string $package, string $schema): SchemaDefinitionInterface;
}

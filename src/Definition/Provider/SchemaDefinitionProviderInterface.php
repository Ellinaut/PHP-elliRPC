<?php

namespace Ellinaut\ElliRPC\Definition\Provider;

use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface SchemaDefinitionProviderInterface
{
    /**
     * @param string $name
     * @return SchemaDefinitionInterface
     */
    public function getSchemaDefinition(string $name): SchemaDefinitionInterface;
}

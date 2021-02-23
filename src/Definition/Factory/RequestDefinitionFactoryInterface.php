<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\RequestDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface RequestDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return RequestDefinitionInterface
     */
    public function createDefinition(array $input): RequestDefinitionInterface;
}

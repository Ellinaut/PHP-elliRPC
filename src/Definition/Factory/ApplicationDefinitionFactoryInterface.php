<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface ApplicationDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return ApplicationDefinitionInterface
     */
    public function createDefinition(array $input): ApplicationDefinitionInterface;
}

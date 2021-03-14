<?php

namespace Ellinaut\ElliRPC\Server\Definition;

use Ellinaut\ElliRPC\Definition\Factory\ApplicationDefinitionFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class JsonDefinitionProvider extends ArrayDefinitionProvider
{
    /**
     * @param ApplicationDefinitionFactoryInterface $applicationDefinitionFactory
     * @param string $rawApplicationDefinition
     * @throws Throwable
     */
    public function __construct(
        ApplicationDefinitionFactoryInterface $applicationDefinitionFactory,
        string $rawApplicationDefinition
    ) {
        parent::__construct(
            $applicationDefinitionFactory,
            json_decode($rawApplicationDefinition, true, 512, JSON_THROW_ON_ERROR)
        );
    }
}

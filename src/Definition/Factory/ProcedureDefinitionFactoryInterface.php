<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface ProcedureDefinitionFactoryInterface
{
    /**
     * @param string $name
     * @param array $input
     * @return ProcedureDefinitionInterface
     */
    public function createDefinition(string $name, array $input): ProcedureDefinitionInterface;
}

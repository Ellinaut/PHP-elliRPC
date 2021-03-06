<?php

namespace Ellinaut\ElliRPC\Definition\Factory;

use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface ProcedureDefinitionFactoryInterface
{
    /**
     * @param array $input
     * @return ProcedureDefinitionInterface
     */
    public function createDefinition(array $input): ProcedureDefinitionInterface;
}

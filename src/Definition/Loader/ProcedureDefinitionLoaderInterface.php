<?php

namespace Ellinaut\ElliRPC\Definition\Loader;

use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionLoaderException;

/**
 * @author Philipp Marien
 */
interface ProcedureDefinitionLoaderInterface
{
    /**
     * @param string $package
     * @param string $procedure
     * @return ProcedureDefinitionInterface
     * @throws DefinitionLoaderException
     */
    public function loadProcedureDefinition(string $package, string $procedure): ProcedureDefinitionInterface;
}

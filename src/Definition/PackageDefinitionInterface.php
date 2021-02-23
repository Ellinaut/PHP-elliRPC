<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return ProcedureDefinitionInterface[]
     */
    public function getProcedureDefinitions(): array;
}

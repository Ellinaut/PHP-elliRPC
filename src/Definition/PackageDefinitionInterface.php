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
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return ProcedureDefinitionInterface[]
     */
    public function getProcedureDefinitions(): array;
}

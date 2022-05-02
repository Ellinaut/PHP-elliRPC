<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionInterface extends DefinitionInterface
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
    public function getProcedures(): array;

    /**
     * @return SchemaDefinitionInterface[]
     */
    public function getSchemas(): array;

    /**
     * @return ErrorDefinitionInterface[]
     */
    public function getErrors(): array;
}

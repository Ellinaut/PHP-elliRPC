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
     * @return string|null
     */
    public function getFallbackLanguage(): ?string;

    /**
     * @return ProcedureDefinitionInterface[]
     */
    public function getProcedureDefinitions(): array;

    /**
     * @return SchemaDefinitionInterface[]
     */
    public function getSchemaDefinitions(): array;

    /**
     * @return ErrorDefinitionInterface[]
     */
    public function getErrorDefinitions(): array;
}

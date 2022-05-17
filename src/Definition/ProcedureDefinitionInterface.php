<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface ProcedureDefinitionInterface extends DefinitionInterface
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
     * @return TransportDefinitionInterface
     */
    public function getRequestDefinition(): TransportDefinitionInterface;

    /**
     * @return TransportDefinitionInterface
     */
    public function getResponseDefinition(): TransportDefinitionInterface;

    /**
     * @return string[]
     */
    public function getErrors(): array;

    /**
     * @return string|null
     */
    public function getAllowedUsage(): ?string;
}

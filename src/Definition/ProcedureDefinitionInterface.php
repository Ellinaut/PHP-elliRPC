<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface ProcedureDefinitionInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string[]
     */
    public function getMethods(): array;

    /**
     * @return string[]
     */
    public function getContentTypes(): array;

    /**
     * @return RequestDefinitionInterface
     */
    public function getRequestDefinition(): RequestDefinitionInterface;

    /**
     * @return DataDefinitionInterface|null
     */
    public function getResponseDataDefinition(): ?DataDefinitionInterface;
}

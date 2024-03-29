<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface PropertyDefinitionInterface extends DefinitionInterface
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
     * @return PropertyTypeDefinitionInterface
     */
    public function getTypeDefinition(): PropertyTypeDefinitionInterface;
}

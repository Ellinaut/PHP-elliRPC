<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
interface PropertyTypeDefinitionInterface
{
    /**
     * @return string|null
     */
    public function getContext(): ?string;

    /**
     * @return string
     */
    public function getType(): string;

    /**
     * @return string[]
     */
    public function getOptions(): array;
}

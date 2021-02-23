<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class PropertyTypeDefinition implements PropertyTypeDefinitionInterface
{
    /**
     * @var string|null
     */
    private ?string $context;

    /**
     * @var string
     */
    private string $type;

    /**
     * @var string[]
     */
    private array $options;

    /**
     * @param string|null $context
     * @param string $type
     * @param string[] $options
     */
    public function __construct(?string $context, string $type, array $options)
    {
        $this->context = $context;
        $this->type = $type;
        $this->options = $options;
    }

    /**
     * @return string|null
     */
    public function getContext(): ?string
    {
        return $this->context;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string[]
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}

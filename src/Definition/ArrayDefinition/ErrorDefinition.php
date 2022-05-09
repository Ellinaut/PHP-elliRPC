<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\ErrorDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class ErrorDefinition extends AbstractArrayDefinition implements ErrorDefinitionInterface
{
    private ?SchemaReferenceDefinitionInterface $context = null;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateString($definition, 'code');

        self::validateStringOrNull($definition, 'description');

        self::validateDefinitionOrNull($definition, 'context', [SchemaReferenceDefinition::class, 'validate']);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->definition['code'];
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->definition['description'];
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     * @throws DefinitionException
     */
    public function getContext(): ?SchemaReferenceDefinitionInterface
    {
        if (!$this->context && $this->definition['context']) {
            $this->context = new SchemaReferenceDefinition($this->definition['context']);
        }

        return $this->context;
    }

    /**
     * @throws DefinitionException
     */
    public function jsonSerialize(): array
    {
        return [
            'code' => $this->getCode(),
            'description' => $this->getDescription(),
            'context' => $this->getContext()
        ];
    }
}

<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;
use Ellinaut\ElliRPC\Definition\TransportDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class TransportDefinition extends AbstractArrayDefinition implements TransportDefinitionInterface
{
    private ?DataDefinitionInterface $data;
    private ?SchemaReferenceDefinitionInterface $meta;

    public static function validate(array $definition): void
    {
        self::validateDefinitionOrNull($definition, 'data', [DataDefinition::class, 'validate']);

        self::validateDefinitionOrNull($definition, 'meta', [SchemaReferenceDefinition::class, 'validate']);
    }

    /**
     * @return DataDefinitionInterface|null
     * @throws DefinitionException
     */
    public function getDataDefinition(): ?DataDefinitionInterface
    {
        if (!$this->data && $this->definition['data']) {
            $this->data = new DataDefinition($this->definition['data']);
        }

        return $this->data;
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     * @throws DefinitionException
     */
    public function getMetaDefinition(): ?SchemaReferenceDefinitionInterface
    {
        if (!$this->meta && $this->definition['meta']) {
            $this->meta = new SchemaReferenceDefinition($this->definition['meta']);
        }

        return $this->meta;
    }
}

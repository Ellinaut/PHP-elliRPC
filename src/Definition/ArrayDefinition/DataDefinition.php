<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\DataDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaReferenceDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class DataDefinition extends SchemaReferenceDefinition implements DataDefinitionInterface
{
    private ?SchemaReferenceDefinitionInterface $wrappedBy;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        parent::validate($definition);

        self::validateDefinitionOrNull($definition, 'wrappedBy', [SchemaReferenceDefinition::class, 'validate']);

        self::validateBoolean($definition, 'nullable');
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     * @throws DefinitionException
     */
    public function getWrappedByDefinition(): ?SchemaReferenceDefinitionInterface
    {
        if (!$this->wrappedBy && $this->definition['wrappedBy']) {
            $this->wrappedBy = new SchemaReferenceDefinition($this->definition['wrappedBy']);
        }

        return $this->wrappedBy;
    }

    /**
     * @return bool
     */
    public function isNullable(): bool
    {
        return $this->definition['nullable'];
    }

    /**
     * @throws DefinitionException
     */
    public function jsonSerialize(): array
    {
        $data = parent::jsonSerialize();
        $data['wrappedBy'] = $this->getWrappedByDefinition();
        $data['nullable'] = $this->isNullable();

        return $data;
    }
}

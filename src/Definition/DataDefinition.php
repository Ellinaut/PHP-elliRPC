<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class DataDefinition extends SchemaReferenceDefinition implements DataDefinitionInterface
{
    /**
     * @var SchemaReferenceDefinitionInterface|null
     */
    private ?SchemaReferenceDefinitionInterface $wrappedBy;

    /**
     * @param string|null $context
     * @param string $schema
     * @param SchemaReferenceDefinitionInterface|null $wrappedBy
     */
    public function __construct(?string $context, string $schema, ?SchemaReferenceDefinitionInterface $wrappedBy)
    {
        parent::__construct($context, $schema);
        $this->wrappedBy = $wrappedBy;
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getWrappedBy(): ?SchemaReferenceDefinitionInterface
    {
        return $this->wrappedBy;
    }
}

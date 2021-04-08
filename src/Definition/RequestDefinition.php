<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class RequestDefinition implements RequestDefinitionInterface
{
    /**
     * @var DataDefinitionInterface|null
     */
    private ?DataDefinitionInterface $requestDataDefinition;

    /**
     * @var SchemaReferenceDefinitionInterface|null
     */
    private ?SchemaReferenceDefinitionInterface $paginatedByDefinition;

    /**
     * @var string[]
     */
    private array $sortedByDefinition;

    /**
     * @param DataDefinitionInterface|null $requestDataDefinition
     * @param SchemaReferenceDefinitionInterface|null $paginatedByDefinition
     * @param string[] $sortedByDefinition
     */
    public function __construct(
        ?DataDefinitionInterface $requestDataDefinition,
        ?SchemaReferenceDefinitionInterface $paginatedByDefinition,
        array $sortedByDefinition
    ) {
        $this->requestDataDefinition = $requestDataDefinition;
        $this->paginatedByDefinition = $paginatedByDefinition;
        $this->sortedByDefinition = $sortedByDefinition;
    }

    /**
     * @return DataDefinitionInterface|null
     */
    public function getRequestDataDefinition(): ?DataDefinitionInterface
    {
        return $this->requestDataDefinition;
    }

    /**
     * @return SchemaReferenceDefinitionInterface|null
     */
    public function getPaginatedByDefinition(): ?SchemaReferenceDefinitionInterface
    {
        return $this->paginatedByDefinition;
    }

    /**
     * @return string[]
     */
    public function getSortedByDefinition(): array
    {
        return $this->sortedByDefinition;
    }
}

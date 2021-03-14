<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class PackageDefinition implements PackageDefinitionInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var ProcedureDefinitionInterface[]
     */
    private array $procedureDefinitions;

    /**
     * @param string $name
     * @param string|null $description
     * @param ProcedureDefinitionInterface[] $procedureDefinitions
     */
    public function __construct(string $name, ?string $description, array $procedureDefinitions)
    {
        $this->name = $name;
        $this->description = $description;
        $this->procedureDefinitions = $procedureDefinitions;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return ProcedureDefinitionInterface[]
     */
    public function getProcedureDefinitions(): array
    {
        return $this->procedureDefinitions;
    }
}

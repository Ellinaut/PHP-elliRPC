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
     * @var ProcedureDefinitionInterface[]
     */
    private array $procedureDefinitions;

    /**
     * @param string $name
     * @param ProcedureDefinitionInterface[] $procedureDefinitions
     */
    public function __construct(string $name, array $procedureDefinitions)
    {
        $this->name = $name;
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
     * @return ProcedureDefinitionInterface[]
     */
    public function getProcedureDefinitions(): array
    {
        return $this->procedureDefinitions;
    }
}

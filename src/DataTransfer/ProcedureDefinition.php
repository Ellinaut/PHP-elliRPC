<?php

namespace Ellinaut\ElliRPC\DataTransfer;

/**
 * @author Philipp Marien
 */
class ProcedureDefinition
{
    /**
     * @var string
     */
    private string $packageName;

    /**
     * @var string
     */
    private string $procedureName;

    /**
     * @param string $packageName
     * @param string $procedureName
     */
    public function __construct(string $packageName, string $procedureName)
    {
        $this->packageName = $packageName;
        $this->procedureName = $procedureName;
    }

    /**
     * @return string
     */
    public function getPackageName(): string
    {
        return $this->packageName;
    }

    /**
     * @return string
     */
    public function getProcedureName(): string
    {
        return $this->procedureName;
    }
}

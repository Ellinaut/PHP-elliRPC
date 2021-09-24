<?php

namespace Ellinaut\ElliRPC\DataTransfer;

use Throwable;

/**
 * @author Philipp Marien
 */
class ExecutionResult
{
    /**
     * @var ProcedureDefinition
     */
    private ProcedureDefinition $definition;

    /**
     * @var array|null
     */
    private ?array $data;

    /**
     * @var Throwable|null
     */
    private ?Throwable $exception;

    /**
     * @param ProcedureDefinition $definition
     * @param array|null $data
     * @param Throwable|null $exception
     */
    public function __construct(ProcedureDefinition $definition, ?array $data, ?Throwable $exception)
    {
        $this->definition = $definition;
        $this->data = $data;
        $this->exception = $exception;
    }

    /**
     * @return ProcedureDefinition
     */
    public function getDefinition(): ProcedureDefinition
    {
        return $this->definition;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return Throwable|null
     */
    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}

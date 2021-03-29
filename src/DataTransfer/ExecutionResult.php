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
     * @var ProcedureBody|null
     */
    private ?ProcedureBody $body;

    /**
     * @var Throwable|null
     */
    private ?Throwable $exception;

    /**
     * @param ProcedureDefinition $definition
     * @param ProcedureBody|null $body
     * @param Throwable|null $exception
     */
    public function __construct(ProcedureDefinition $definition, ?ProcedureBody $body, ?Throwable $exception)
    {
        $this->definition = $definition;
        $this->body = $body;
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
     * @return ProcedureBody|null
     */
    public function getBody(): ?ProcedureBody
    {
        return $this->body;
    }

    /**
     * @return Throwable|null
     */
    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}

<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureResult
{
    /**
     * @var Procedure
     */
    private Procedure $procedure;

    /**
     * @var array|null
     */
    private ?array $data;

    /**
     * @var Throwable|null
     */
    private ?Throwable $exception;

    /**
     * @param Procedure $procedure
     * @param array|null $data
     * @param Throwable|null $exception
     */
    public function __construct(Procedure $procedure, ?array $data, ?Throwable $exception = null)
    {
        $this->procedure = $procedure;
        $this->data = $data;
        $this->exception = $exception;
    }

    /**
     * @return Procedure
     */
    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }

    /**
     * @return array|null
     */
    public function getData(): ?array
    {
        return $this->data;
    }

    /**
     * @return bool
     */
    public function isSuccessful(): bool
    {
        return $this->getException() !== null;
    }

    /**
     * @return Throwable|null
     */
    public function getException(): ?Throwable
    {
        return $this->exception;
    }
}

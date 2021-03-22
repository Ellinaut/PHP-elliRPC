<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

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
     * @var string
     */
    private string $status;

    /**
     * @param Procedure $procedure
     * @param array|null $responseData
     * @param string $status
     */
    public function __construct(Procedure $procedure, ?array $responseData, string $status)
    {
        $this->procedure = $procedure;
        $this->data = $responseData;
        $this->status = $status;
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
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }
}

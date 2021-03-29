<?php

namespace Ellinaut\ElliRPC\DataTransfer;

/**
 * @author Philipp Marien
 */
class Procedure
{
    /**
     * @var ProcedureDefinition
     */
    private ProcedureDefinition $definition;

    /**
     * @var ProcedureBody
     */
    private ProcedureBody $body;

    /**
     * @param ProcedureDefinition $definition
     * @param ProcedureBody $body
     */
    public function __construct(ProcedureDefinition $definition, ProcedureBody $body)
    {
        $this->definition = $definition;
        $this->body = $body;
    }

    /**
     * @return ProcedureDefinition
     */
    public function getDefinition(): ProcedureDefinition
    {
        return $this->definition;
    }

    /**
     * @return ProcedureBody
     */
    public function getBody(): ProcedureBody
    {
        return $this->body;
    }
}

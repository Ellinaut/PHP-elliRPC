<?php

namespace Ellinaut\ElliRPC\DataTransfer\FormattingContext;

use Ellinaut\ElliRPC\DataTransfer\ProcedureDefinition;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionContext extends AbstractFormattingContext
{
    /**
     * @var ProcedureDefinition
     */
    private ProcedureDefinition $procedure;

    /**
     * @param string $contentTypeExtension
     * @param string[] $acceptedHeader
     * @param ProcedureDefinition $procedure
     */
    public function __construct(string $contentTypeExtension, array $acceptedHeader, ProcedureDefinition $procedure)
    {
        parent::__construct($contentTypeExtension, $acceptedHeader);
        $this->procedure = $procedure;
    }

    /**
     * @return ProcedureDefinition
     */
    public function getProcedure(): ProcedureDefinition
    {
        return $this->procedure;
    }
}

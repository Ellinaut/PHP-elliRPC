<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\Procedure;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionRequest extends AbstractRequest
{
    /**
     * @var Procedure
     */
    private Procedure $procedure;

    /**
     * @param AbstractFormattingContext $context
     * @param Procedure $procedure
     * @param string[][] $requestHeaders
     */
    public function __construct(
        AbstractFormattingContext $context,
        Procedure $procedure,
        array $requestHeaders = []
    ) {
        parent::__construct($context, $requestHeaders);
        $this->procedure = $procedure;
    }

    /**
     * @return Procedure
     */
    public function getProcedure(): Procedure
    {
        return $this->procedure;
    }
}

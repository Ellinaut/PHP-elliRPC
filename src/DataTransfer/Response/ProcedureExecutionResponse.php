<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\ProcedureBody;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionResponse extends AbstractFormatableResponse
{
    /**
     * @var ProcedureBody
     */
    private ProcedureBody $content;

    /**
     * @param AbstractFormattingContext $context
     * @param ProcedureBody $content
     */
    public function __construct(AbstractFormattingContext $context, ProcedureBody $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return ProcedureBody
     */
    public function getContent(): ProcedureBody
    {
        return $this->content;
    }
}

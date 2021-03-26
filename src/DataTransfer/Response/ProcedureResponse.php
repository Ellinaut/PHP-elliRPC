<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Workflow\ProcedureResult;

/**
 * @author Philipp Marien
 */
class ProcedureResponse extends AbstractFormatableResponse
{
    /**
     * @var ProcedureResult
     */
    private ProcedureResult $content;

    /**
     * @param AbstractResponseContext $context
     * @param ProcedureResult $content
     */
    public function __construct(AbstractResponseContext $context, ProcedureResult $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return ProcedureResult
     */
    public function getContent(): ProcedureResult
    {
        return $this->content;
    }
}

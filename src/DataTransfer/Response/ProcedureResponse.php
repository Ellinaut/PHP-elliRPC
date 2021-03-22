<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
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
     * @param ResponseContext $context
     * @param ProcedureResult $content
     */
    public function __construct(ResponseContext $context, ProcedureResult $content)
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

<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\Procedure;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionBulkRequest extends AbstractRequest
{
    /**
     * @var Procedure[]
     */
    private array $procedures;

    /**
     * @param AbstractFormattingContext $context
     * @param Procedure[] $procedures
     * @param string[][] $requestHeaders
     */
    public function __construct(AbstractFormattingContext $context, array $procedures, array $requestHeaders = [])
    {
        parent::__construct($context, $requestHeaders);
        $this->procedures = $procedures;
    }

    /**
     * @return Procedure[]
     */
    public function getProcedures(): array
    {
        return $this->procedures;
    }
}

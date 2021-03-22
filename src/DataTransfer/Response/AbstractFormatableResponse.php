<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;

/**
 * @author Philipp Marien
 */
abstract class AbstractFormatableResponse
{
    /**
     * @var ResponseContext
     */
    private ResponseContext $context;

    /**
     * @param ResponseContext $context
     */
    public function __construct(ResponseContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return ResponseContext
     */
    public function getContext(): ResponseContext
    {
        return $this->context;
    }
}


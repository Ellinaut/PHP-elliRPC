<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;

/**
 * @author Philipp Marien
 */
abstract class AbstractFormatableResponse
{
    /**
     * @var AbstractResponseContext
     */
    private AbstractResponseContext $context;

    /**
     * @param AbstractResponseContext $context
     */
    public function __construct(AbstractResponseContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return AbstractResponseContext
     */
    public function getContext(): AbstractResponseContext
    {
        return $this->context;
    }
}


<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

/**
 * @author Philipp Marien
 */
abstract class AbstractFormatableResponse
{
    /**
     * @var AbstractFormattingContext
     */
    private AbstractFormattingContext $context;

    /**
     * @param AbstractFormattingContext $context
     */
    public function __construct(AbstractFormattingContext $context)
    {
        $this->context = $context;
    }

    /**
     * @return AbstractFormattingContext
     */
    public function getContext(): AbstractFormattingContext
    {
        return $this->context;
    }
}


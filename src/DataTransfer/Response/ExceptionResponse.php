<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Throwable;

/**
 * @author Philipp Marien
 */
class ExceptionResponse extends AbstractFormatableResponse
{
    /**
     * @var Throwable
     */
    private Throwable $exception;

    /**
     * @param AbstractFormattingContext $context
     * @param Throwable $exception
     */
    public function __construct(AbstractFormattingContext $context, Throwable $exception)
    {
        parent::__construct($context);
        $this->exception = $exception;
    }

    /**
     * @return Throwable
     */
    public function getException(): Throwable
    {
        return $this->exception;
    }
}

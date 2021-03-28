<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
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
     * @param AbstractResponseContext $context
     * @param Throwable $exception
     */
    public function __construct(AbstractResponseContext $context, Throwable $exception)
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

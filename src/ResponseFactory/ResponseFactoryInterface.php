<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface ResponseFactoryInterface
{
    /**
     * @param AbstractFormattingContext $context
     * @return bool
     */
    public function supports(AbstractFormattingContext $context): bool;

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface;
}

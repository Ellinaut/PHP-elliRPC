<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface ResponseFactoryInterface
{
    /**
     * @param AbstractResponseContext $context
     * @return bool
     */
    public function supports(AbstractResponseContext $context): bool;

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface;
}

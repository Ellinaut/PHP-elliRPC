<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface ResponseFactoryInterface
{
    /**
     * @param ResponseContext $context
     * @return bool
     */
    public function supports(ResponseContext $context): bool;

    /**
     * @param AbstractFormatableResponse $formatableResponse
     * @return ResponseInterface
     */
    public function createResponse(AbstractFormatableResponse $formatableResponse): ResponseInterface;
}

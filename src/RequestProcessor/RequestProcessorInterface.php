<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;

/**
 * @author Philipp Marien
 */
interface RequestProcessorInterface
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse;
}

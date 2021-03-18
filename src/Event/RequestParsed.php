<?php

namespace Ellinaut\ElliRPC\Event;

use Ellinaut\ElliRPC\Request\AbstractRequest;

/**
 * @author Philipp Marien
 */
class RequestParsed
{
    /**
     * @var AbstractRequest
     */
    private AbstractRequest $request;

    /**
     * @param AbstractRequest $request
     */
    public function __construct(AbstractRequest $request)
    {
        $this->request = $request;
    }

    /**
     * @return AbstractRequest
     */
    public function getRequest(): AbstractRequest
    {
        return $this->request;
    }
}

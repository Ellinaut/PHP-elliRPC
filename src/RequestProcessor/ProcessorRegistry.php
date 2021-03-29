<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;

/**
 * @author Philipp Marien
 */
class ProcessorRegistry implements RequestProcessorInterface
{
    /**
     * @var RequestProcessorInterface[]
     */
    private array $processors = [];

    public function register(RequestProcessorInterface $processor, string $requestClass): void
    {
        $this->processors[$requestClass] = $processor;
    }

    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        $requestClass = get_class($request);

        if (!array_key_exists($requestClass, $this->processors)) {
            throw new InvalidRequestProcessorException();
        }

        return $this->processors[$requestClass]->process($request);
    }
}

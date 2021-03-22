<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Psr\Http\Message\ResponseInterface;

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
     * @return ResponseInterface
     * @throws InvalidRequestProcessorException
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        $requestClass = get_class($request);

        if (!array_key_exists($requestClass, $this->processors)) {
            throw new InvalidRequestProcessorException();
        }

        return $this->processors[$requestClass]->processRequest($request);
    }
}

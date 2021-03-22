<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\FileHandler\FileHandlerInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileDownloadRequest;
use Ellinaut\ElliRPC\ResponseFactory\AbstractResponseFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 * @todo move responses to response factory
 */
class FileDownloadProcessor extends AbstractResponseFactory implements RequestProcessorInterface
{
    /**
     * @var FileHandlerInterface
     */
    private FileHandlerInterface $fileHandler;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param StreamFactoryInterface $streamFactory
     * @param FileHandlerInterface $fileHandler
     */
    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        FileHandlerInterface $fileHandler
    ) {
        parent::__construct($responseFactory, $streamFactory);
        $this->fileHandler = $fileHandler;
    }

    /**
     * @param AbstractRequest $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function processRequest(AbstractRequest $request): ResponseInterface
    {
        if (!$request instanceof FileDownloadRequest) {
            throw new InvalidRequestProcessorException();
        }

        $file = $this->fileHandler->readFile($request->getPublicFileLocation());

        return $this->createResponseWithBody(
            $file->getContent(),
            $file->getMimeType()
        );
    }
}

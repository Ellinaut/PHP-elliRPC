<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\FileHandler\FileHandlerInterface;
use Ellinaut\ElliRPC\Processor\RequestProcessorInterface;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileUploadRequest;
use Ellinaut\ElliRPC\ResponseFactory\AbstractResponseFactory;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 * @todo move responses to response factory
 */
class FileUploadProcessor extends AbstractResponseFactory implements RequestProcessorInterface
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
        if (!$request instanceof FileUploadRequest) {
            throw new InvalidRequestProcessorException();
        }

        $file = $this->fileHandler->createFile(
            $request->getPublicFileLocation(),
            $request->getFileContent()
        );

        return $this->createResponse(201)->withHeader(
            'Content-Location',
            $file->getContentLocationValue()
        );
    }
}

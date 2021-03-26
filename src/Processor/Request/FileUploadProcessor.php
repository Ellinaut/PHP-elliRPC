<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\FileResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\FileReferenceResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\FileHandler\FileHandlerInterface;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileUploadRequest;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileUploadProcessor extends AbstractRequestProcessor
{
    /**
     * @var FileHandlerInterface
     */
    private FileHandlerInterface $fileHandler;

    /**
     * @param ResponseFactoryInterface $responseFactory
     * @param FileHandlerInterface $fileHandler
     */
    public function __construct(ResponseFactoryInterface $responseFactory, FileHandlerInterface $fileHandler)
    {
        parent::__construct($responseFactory);
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
        $responseContext = new FileResponseContext($request->getRequestedContentType());
        $this->throwExceptionOnUnsupportedResponseFormat($responseContext);

        $file = $this->fileHandler->createFile(
            $request->getPublicFileLocation(),
            $request->getFileContent()
        );

        return $this->createResponse(new FileReferenceResponse($responseContext, $file));
    }
}

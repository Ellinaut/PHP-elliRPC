<?php

namespace Ellinaut\ElliRPC\Processor\Request;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\FileResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Response\FileResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;
use Ellinaut\ElliRPC\FileHandler\FileHandlerInterface;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileDownloadRequest;
use Ellinaut\ElliRPC\ResponseFactory\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileDownloadProcessor extends AbstractRequestProcessor
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
        if (!$request instanceof FileDownloadRequest) {
            throw new InvalidRequestProcessorException();
        }

        $responseContext = new FileResponseContext($request->getRequestedContentType());
        $this->throwExceptionOnUnsupportedResponseFormat($responseContext);

        $file = $this->fileHandler->readFile($request->getPublicFileLocation());

        return $this->createResponse(new FileResponse($responseContext, $file));
    }
}

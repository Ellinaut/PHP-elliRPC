<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileUploadRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileReferenceResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;

/**
 * @author Philipp Marien
 */
class FileUploadProcessor extends AbstractFileProcessor
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if (!$request instanceof FileUploadRequest) {
            throw new InvalidRequestProcessorException();
        }

        return new FileReferenceResponse(
            $request->getContext(),
            $this->getFileHandler()->createFile(
                $request->getPublicFileLocation(),
                $request->getFileContent()
            )
        );
    }
}

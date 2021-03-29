<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileDownloadRequest;
use Ellinaut\ElliRPC\DataTransfer\Response\AbstractFormatableResponse;
use Ellinaut\ElliRPC\DataTransfer\Response\FileResponse;
use Ellinaut\ElliRPC\Exception\InvalidRequestProcessorException;

/**
 * @author Philipp Marien
 */
class FileDownloadProcessor extends AbstractFileProcessor
{
    /**
     * @param AbstractRequest $request
     * @return AbstractFormatableResponse
     */
    public function process(AbstractRequest $request): AbstractFormatableResponse
    {
        if (!$request instanceof FileDownloadRequest) {
            throw new InvalidRequestProcessorException();
        }

        return new FileResponse(
            $request->getContext(),
            $this->getFileHandler()->readFile($request->getPublicFileLocation())
        );
    }
}

<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\Request\AbstractRequest;
use Ellinaut\ElliRPC\Request\FileDownloadRequest;
use Ellinaut\ElliRPC\Request\FileUploadRequest;
use Psr\Http\Message\RequestInterface;

/**
 * @author Philipp Marien
 */
class FileRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        $endpoint = $this->parseEndpointFromUri($request->getUri());
        if ($endpoint !== '@files') {
            return null;
        }

        $parts = explode('/', $this->parseAdjustedPathFromUri($request->getUri()));

        $fileName = array_pop($parts);
        if (empty($fileName)) {
            return null;
        }

        $directoryPath = implode('/', $parts);

        switch (strtoupper($request->getMethod())) {
            case 'GET':
                return new FileDownloadRequest(
                    $request->getHeaders(),
                    $this->parseContentTypeExtensionFromUri($request->getUri()),
                    $fileName,
                    $directoryPath,
                );
            case 'POST':
                return new FileUploadRequest(
                    $request->getHeaders(),
                    $this->parseContentTypeExtensionFromUri($request->getUri()),
                    $fileName,
                    $directoryPath,
                    $request->getBody()->getContents(),
                );
        }

        return null;
    }
}

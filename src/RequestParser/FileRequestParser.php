<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\FileContext;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\FileReferenceContext;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileDownloadRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\FileUploadRequest;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     * @throws Throwable
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        $endpoint = $this->parseEndpointFromUri($request->getUri());
        if ($endpoint !== '@files') {
            return null;
        }

        $parsedContentType = $this->parseContentTypeExtensionFromUri($request->getUri());

        $publicFileLocation = $this->parseAdjustedPathFromUri($request->getUri());
        if ($parsedContentType !== '') {
            $publicFileLocation .= '.' . $parsedContentType;
        }

        switch (strtoupper($request->getMethod())) {
            case 'GET':
                return new FileDownloadRequest(
                    new FileReferenceContext(
                        $parsedContentType,
                        $request->getHeader('Accept')
                    ),
                    $publicFileLocation,
                    $request->getHeaders()
                );
            case 'POST':
                return new FileUploadRequest(
                    new FileContext(
                        $parsedContentType,
                        $request->getHeader('Accept')
                    ),
                    $publicFileLocation,
                    $request->getBody()->getContents(),
                    $request->getHeaders()
                );
        }

        return null;
    }
}

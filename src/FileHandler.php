<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\File\FileLocatorInterface;
use Ellinaut\ElliRPC\File\FilesystemInterface;
use Ellinaut\ElliRPC\File\ContentTypeGuesserInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;

/**
 * @author Philipp Marien
 */
class FileHandler extends AbstractHttpHandler
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        protected readonly FileLocatorInterface $fileLocator,
        protected readonly FilesystemInterface $filesystem,
        protected readonly ContentTypeGuesserInterface $contentTypeGuesser
    ) {
        parent::__construct($streamFactory, $responseFactory);
    }

    public function executeGetFile(RequestInterface $request): ResponseInterface
    {
        $realPath = $this->fileLocator->resolveRealPath(
            $this->getLastPathPart($request, '/files/')
        );

        $file = $this->filesystem->loadFile($realPath);
        if (!$file || !$file->isReadable()) {
            $this->responseFactory->createResponse(404);
        }

        return $this->responseFactory->createResponse()
            ->withBody(
                $this->streamFactory->createStreamFromFile(
                    $file->getRealPath()
                )
            )
            ->withHeader(
                'Content-Type',
                $this->contentTypeGuesser->guessContentType($file->getRealPath())
            )
            ->withHeader(
                'Content-Disposition',
                'inline; filename=' . $this->fileLocator->resolveRPCName($file->getRealPath())
            );
    }

    public function executeUploadFile(ServerRequestInterface $request): ResponseInterface
    {
        $rpcPath = $this->getLastPathPart($request, '/files/');
        $realPath = $this->fileLocator->resolveRealPath($rpcPath);

        $this->filesystem->storeFile(
            $realPath,
            $request->getBody()->getContents(),
            strtoupper($request->getMethod()) === 'PUT'
        );

        return $this->responseFactory->createResponse(201)
            ->withHeader(
                'Location',
                $this->getFirstPathPart($request, '/files/')
                . '/files' . $this->fileLocator->resolveRPCPath($realPath)
            );
    }

    public function executeDeleteFile(RequestInterface $request): ResponseInterface
    {
        $rpcPath = $this->getLastPathPart($request, '/files/');

        $this->filesystem->deleteFile(
            $this->fileLocator->resolveRealPath($rpcPath)
        );

        return $this->responseFactory->createResponse(204);
    }
}

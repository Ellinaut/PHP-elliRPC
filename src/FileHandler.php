<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Error\Factory\ErrorFactoryInterface;
use Ellinaut\ElliRPC\Error\Translator\ErrorTranslatorInterface;
use Ellinaut\ElliRPC\Exception\FileExistException;
use Ellinaut\ElliRPC\Exception\FileNotFoundException;
use Ellinaut\ElliRPC\File\FileLocatorInterface;
use Ellinaut\ElliRPC\File\FilesystemInterface;
use Ellinaut\ElliRPC\File\ContentTypeGuesserInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileHandler extends AbstractHttpHandler
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        ErrorFactoryInterface $errorFactory,
        ErrorTranslatorInterface $errorTranslator,
        protected readonly FileLocatorInterface $fileLocator,
        protected readonly FilesystemInterface $filesystem,
        protected readonly ContentTypeGuesserInterface $contentTypeGuesser
    ) {
        parent::__construct($streamFactory, $responseFactory, $errorFactory, $errorTranslator);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeGetFile(RequestInterface $request): ResponseInterface
    {
        try {
            $realPath = $this->fileLocator->resolveRealPath(
                $this->getLastPathPart($request, '/files/')
            );

            $file = $this->filesystem->loadFile($realPath);
            if (!$file || !$file->isReadable()) {
                throw new FileNotFoundException('The requested file could not be found.');
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
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeUploadFile(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $rpcPath = $this->getLastPathPart($request, '/files/');
            $realPath = $this->fileLocator->resolveRealPath($rpcPath);

            if (strtoupper($request->getMethod()) !== 'PUT') {
                $file = $this->filesystem->loadFile($realPath);
                if ($file) {
                    throw new FileExistException('A file with the same filename was already uploaded.');
                }
            }

            $this->filesystem->storeFile(
                $realPath,
                $request->getBody()->getContents()
            );

            return $this->responseFactory->createResponse(201)
                ->withHeader(
                    'Location',
                    $this->getFirstPathPart($request, '/files/')
                    . '/files' . $this->fileLocator->resolveRPCPath($realPath)
                );
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeDeleteFile(RequestInterface $request): ResponseInterface
    {
        try {
            $rpcPath = $this->getLastPathPart($request, '/files/');

            $this->filesystem->deleteFile(
                $this->fileLocator->resolveRealPath($rpcPath)
            );

            return $this->responseFactory->createResponse(204);
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }
}

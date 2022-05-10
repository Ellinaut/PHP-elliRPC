<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Error\Error;
use Ellinaut\ElliRPC\Error\Factory\ErrorFactoryInterface;
use Ellinaut\ElliRPC\Error\HttpErrorInterface;
use Ellinaut\ElliRPC\Error\TranslateableError;
use Ellinaut\ElliRPC\Error\Translator\ErrorTranslatorInterface;
use JsonSerializable;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractHttpHandler
{
    public function __construct(
        protected readonly StreamFactoryInterface $streamFactory,
        protected readonly ResponseFactoryInterface $responseFactory,
        protected readonly ErrorFactoryInterface $errorFactory,
        protected readonly ErrorTranslatorInterface $errorTranslator
    ) {
    }

    /**
     * @param RequestInterface $request
     * @param string $separator
     * @return string
     */
    protected function getFirstPathPart(RequestInterface $request, string $separator): string
    {
        $pathParts = explode($separator, $request->getUri()->getPath());

        return $pathParts[0];
    }

    /**
     * @param RequestInterface $request
     * @param string $separator
     * @return string
     */
    protected function getLastPathPart(RequestInterface $request, string $separator): string
    {
        $pathParts = explode($separator, $request->getUri()->getPath());

        return $pathParts[array_key_last($pathParts)];
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws Throwable
     */
    protected function getDecodedJsonRequestBody(RequestInterface $request): array
    {
        return json_decode(
            $request->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param Throwable $throwable
     * @return Error
     */
    protected function createErrorFromThrowable(Throwable $throwable): Error
    {
        $error = $this->errorFactory->createFromThrowable($throwable);
        if (!$error) {
            $error = new TranslateableError(
                'en',
                $throwable->getMessage(),
                (string)$throwable->getCode()
            );
        }

        if ($error instanceof TranslateableError) {
            $this->errorTranslator->translate($error);
        }

        return $error;
    }

    /**
     * @param JsonSerializable $body
     * @param int $status
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function createJsonResponse(JsonSerializable $body, int $status = 200): ResponseInterface
    {
        return $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                $this->streamFactory->createStream(
                    json_encode($body, JSON_THROW_ON_ERROR)
                )
            );
    }

    /**
     * @param Throwable $throwable
     * @param int $status
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function createJsonErrorResponse(Throwable $throwable, int $status = 500): ResponseInterface
    {
        $error = $this->createErrorFromThrowable($throwable);
        if ($error instanceof HttpErrorInterface) {
            $status = $error->getStatusCode();
        }

        return $this->responseFactory->createResponse($status)
            ->withHeader('Content-Type', 'application/json')
            ->withBody(
                $this->streamFactory->createStream(
                    json_encode($error, JSON_THROW_ON_ERROR)
                )
            );
    }
}

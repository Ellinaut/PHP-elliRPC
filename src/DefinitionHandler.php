<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Definition\Loader\PackageDefinitionLoaderInterface;
use Ellinaut\ElliRPC\Error\Factory\ErrorFactoryInterface;
use Ellinaut\ElliRPC\Error\Translator\ErrorTranslatorInterface;
use Ellinaut\ElliRPC\Value\JsonSerializableArray;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class DefinitionHandler extends AbstractHttpHandler
{
    public function __construct(
        StreamFactoryInterface $streamFactory,
        ResponseFactoryInterface $responseFactory,
        ErrorFactoryInterface $errorFactory,
        ErrorTranslatorInterface $errorTranslator,
        protected readonly PackageDefinitionLoaderInterface $packageDefinitionLoader,
        protected readonly string $application,
        protected readonly ?string $description
    ) {
        parent::__construct($streamFactory, $responseFactory, $errorFactory, $errorTranslator);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeGetDocumentation(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->createJsonResponse(
                new JsonSerializableArray([
                    'application' => $this->application,
                    'description' => $this->description,
                    'extensions' => [],//@todo
                    'packages' => $this->packageDefinitionLoader->loadPackageDefinitions()
                ])
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
    public function executeGetPackageDefinition(RequestInterface $request): ResponseInterface
    {
        try {
            return $this->createJsonResponse(
                $this->packageDefinitionLoader->loadPackageDefinition(
                    $this->getLastPathPart($request, '/definitions/')
                ),
            );
        } catch (Throwable $throwable) {
            return $this->createJsonErrorResponse($throwable);
        }
    }
}

<?php

namespace Ellinaut\ElliRPC;

use Ellinaut\ElliRPC\Definition\Loader\PackageDefinitionLoaderInterface;
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
        protected readonly string $application,
        protected readonly ?string $description,
        protected readonly PackageDefinitionLoaderInterface $packageDefinitionLoader
    ) {
        parent::__construct($streamFactory, $responseFactory);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeGetDocumentation(RequestInterface $request): ResponseInterface
    {
        return $this->createJsonResponse(
            new JsonSerializableArray([
                'application' => $this->application,
                'description' => $this->description,
                'extensions' => [],//@todo
                'packages' => $this->packageDefinitionLoader->loadPackageDefinitions()
            ])
        );
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    public function executeGetPackageDefinition(RequestInterface $request): ResponseInterface
    {

        return $this->createJsonResponse(
            $this->packageDefinitionLoader->loadPackageDefinition(
                $this->getLastPathPart($request, '/definitions/')
            ),
        );
    }
}

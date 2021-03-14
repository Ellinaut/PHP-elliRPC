<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use Ellinaut\ElliRPC\Definition\ApplicationDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
interface DefinitionResponseFactoryInterface
{
    /**
     * @param $application
     * @return ResponseInterface
     */
    public function createDocumentationResponse(ApplicationDefinitionInterface $application): ResponseInterface;


    /**
     * @param PackageDefinitionInterface[] $packages
     * @return ResponseInterface
     */
    public function createPackagesResponse(array $packages): ResponseInterface;

    /**
     * @param SchemaDefinitionInterface $schema
     * @return ResponseInterface
     */
    public function createSchemaResponse(SchemaDefinitionInterface $schema): ResponseInterface;
}

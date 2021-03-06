<?php

namespace Ellinaut\ElliRPC\Server;

use Ellinaut\ElliRPC\Definition\Provider\PackageDefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\Provider\SchemaDefinitionProviderInterface;
use Ellinaut\ElliRPC\Server\Formatter\PackageDefinitionFormatterInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
class ElliRPCServer
{
    /**
     * @var PackageDefinitionProviderInterface
     */
    protected PackageDefinitionProviderInterface $packageDefinitionProvider;

    /**
     * @var SchemaDefinitionProviderInterface
     */
    protected SchemaDefinitionProviderInterface $schemaDefinitionProvider;

    /**
     * @var PackageDefinitionFormatterInterface[]
     */
    protected array $definitionFormatters = [];

    /**
     * @param string $format
     * @param PackageDefinitionFormatterInterface $formatter
     */
    public function addDefinitionFormatter(string $format, PackageDefinitionFormatterInterface $formatter): void
    {
        $this->definitionFormatters[$format] = $formatter;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handleRequest(RequestInterface $request): ResponseInterface
    {

    }


}

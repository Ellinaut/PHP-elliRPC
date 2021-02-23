<?php

namespace Ellinaut\ElliRPC\Server;

use Ellinaut\ElliRPC\Definition\Provider\PackageDefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\Provider\SchemaDefinitionProviderInterface;
use Ellinaut\ElliRPC\Server\Formatter\DefinitionFormatterInterface;
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
     * @var DefinitionFormatterInterface[]
     */
    protected array $definitionFormatters = [];

    /**
     * @param string $format
     * @param DefinitionFormatterInterface $formatter
     */
    public function addDefinitionFormatter(string $format, DefinitionFormatterInterface $formatter): void
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

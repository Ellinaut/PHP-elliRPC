<?php

namespace Ellinaut\ElliRPC\Client\Definition;

use Ellinaut\ElliRPC\Client\Connector\AbstractRemoteConnector;
use Ellinaut\ElliRPC\Definition\Factory\SchemaDefinitionFactoryInterface;
use Ellinaut\ElliRPC\Definition\Provider\SchemaDefinitionProviderInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class SchemaDefinitionLoader extends AbstractRemoteConnector implements SchemaDefinitionProviderInterface
{
    /**
     * @var SchemaDefinitionFactoryInterface
     */
    private SchemaDefinitionFactoryInterface $schemaDefinitionFactory;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @param UriFactoryInterface $uriFactory
     * @param ClientInterface $client
     * @param SchemaDefinitionFactoryInterface $schemaDefinitionFactory
     * @param string $remoteApi
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory,
        ClientInterface $client,
        SchemaDefinitionFactoryInterface $schemaDefinitionFactory,
        string $remoteApi
    ) {
        parent::__construct($requestFactory, $uriFactory, $streamFactory, $client, $remoteApi);
        $this->schemaDefinitionFactory = $schemaDefinitionFactory;
    }

    /**
     * @param string $name
     * @return SchemaDefinitionInterface
     * @throws Throwable
     */
    public function getSchemaDefinition(string $name): SchemaDefinitionInterface
    {
        $request = $this->buildJsonRequest('GET', '/elliRPC/_schema/' . $name . '.json');

        return $this->schemaDefinitionFactory->createDefinition($this->executeJsonRequest($request));
    }
}

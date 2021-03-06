<?php

namespace Ellinaut\ElliRPC\Client\Definition;

use Ellinaut\ElliRPC\Client\Connector\AbstractRemoteConnector;
use Ellinaut\ElliRPC\Definition\Factory\PackageDefinitionFactoryInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\Provider\PackageDefinitionProviderInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class PackageDefinitionLoader extends AbstractRemoteConnector implements PackageDefinitionProviderInterface
{
    /**
     * @var PackageDefinitionFactoryInterface
     */
    private PackageDefinitionFactoryInterface $packageDefinitionFactory;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @param UriFactoryInterface $uriFactory
     * @param ClientInterface $client
     * @param PackageDefinitionFactoryInterface $packageDefinitionFactory
     * @param string $remoteApi
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        ClientInterface $client,
        PackageDefinitionFactoryInterface $packageDefinitionFactory,
        string $remoteApi
    ) {
        parent::__construct($requestFactory, $uriFactory, $client, $remoteApi);
        $this->packageDefinitionFactory = $packageDefinitionFactory;
    }

    /**
     * @return PackageDefinitionInterface[]
     * @throws Throwable
     */
    public function getPackageDefinitions(): array
    {
        $packages = $this->executeGetJson('/elliRPC/_packages.json')['packages'];

        $packageDefinitions = [];
        foreach ($packages as $package) {
            $packageDefinitions[] = $this->packageDefinitionFactory->createDefinition($package);
        }

        return $packageDefinitions;
    }
}

<?php

namespace Ellinaut\ElliRPC\Client\Connector;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\UriFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
abstract class AbstractRemoteConnector
{
    /**
     * @var RequestFactoryInterface
     */
    private RequestFactoryInterface $requestFactory;

    /**
     * @var UriFactoryInterface
     */
    private UriFactoryInterface $uriFactory;

    /**
     * @var ClientInterface
     */
    private ClientInterface $client;

    /**
     * @var string
     */
    private string $remoteApi;

    /**
     * @param RequestFactoryInterface $requestFactory
     * @param UriFactoryInterface $uriFactory
     * @param ClientInterface $client
     * @param string $remoteApi
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        ClientInterface $client,
        string $remoteApi
    ) {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->client = $client;
        $this->remoteApi = $remoteApi;
    }

    /**
     * @param string $path
     * @return array
     * @throws Throwable
     */
    protected function executeGetJson(string $path): array
    {
        $request = $this->requestFactory->createRequest(
            'GET',
            $this->uriFactory->createUri(
                rtrim($this->remoteApi, '/') . '/' . ltrim($path, '/')
            )
        );

        return json_decode(
            $this->client->sendRequest($request)->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }
}

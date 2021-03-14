<?php

namespace Ellinaut\ElliRPC\Client\Connector;

use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestFactoryInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamFactoryInterface;
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
     * @var StreamFactoryInterface
     */
    private StreamFactoryInterface $streamFactory;

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
     * @param StreamFactoryInterface $streamFactory
     * @param ClientInterface $client
     * @param string $remoteApi
     */
    public function __construct(
        RequestFactoryInterface $requestFactory,
        UriFactoryInterface $uriFactory,
        StreamFactoryInterface $streamFactory,
        ClientInterface $client,
        string $remoteApi
    ) {
        $this->requestFactory = $requestFactory;
        $this->uriFactory = $uriFactory;
        $this->streamFactory = $streamFactory;
        $this->client = $client;
        $this->remoteApi = $remoteApi;
    }

    /**
     * @param string $method
     * @param string $path
     * @param array|null $query
     * @param array|null $body
     * @return RequestInterface
     * @throws Throwable
     */
    protected function buildJsonRequest(
        string $method,
        string $path,
        ?array $query = null,
        ?array $body = null
    ): RequestInterface {
        $uri = $this->uriFactory->createUri(
            rtrim($this->remoteApi, '/') . '/' . ltrim($path, '/')
        );

        if ($query !== null) {
            $uri = $uri->withQuery(http_build_query($query));
        }

        $request = $this->requestFactory->createRequest($method, $uri);
        $request = $request->withHeader('Accept', 'application/json');

        if ($body !== null) {
            $request = $request->withBody(
                $this->streamFactory->createStream(json_encode($body, JSON_THROW_ON_ERROR))
            );

            $request = $request->withHeader('Content-Type', 'application/json');
        }

        //@todo event to manipulate the request

        return $request;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws Throwable
     */
    protected function parseJsonResponse(ResponseInterface $response): array
    {
        return json_decode(
            $response->getBody()->getContents(),
            true,
            512,
            JSON_THROW_ON_ERROR
        );
    }

    /**
     * @param string $path
     * @return array
     * @throws Throwable
     */
    protected function executeJsonRequest(RequestInterface $request): array
    {
        $response = $this->client->sendRequest($request);

        return $this->parseJsonResponse($response);
    }
}

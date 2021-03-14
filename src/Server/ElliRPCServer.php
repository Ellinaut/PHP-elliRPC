<?php

namespace Ellinaut\ElliRPC\Server;

use Ellinaut\ElliRPC\Definition\Provider\DefinitionProviderInterface;
use Ellinaut\ElliRPC\Exception\MissingContentTypeException;
use Ellinaut\ElliRPC\Exception\UnregisteredContentTypeException;
use Ellinaut\ElliRPC\Exception\UnsupportedContentTypeException;
use Ellinaut\ElliRPC\Server\Processor\ProcedureProcessorInterface;
use Ellinaut\ElliRPC\Server\ResponseFactory\DefinitionResponseFactoryInterface;
use Ellinaut\ElliRPC\Server\Value\Procedure;
use Ellinaut\ElliRPC\Server\Value\Transaction;
use Ellinaut\ElliRPC\Server\Value\TransactionResult;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ElliRPCServer
{
    /**
     * @var DefinitionProviderInterface
     */
    protected DefinitionProviderInterface $definitionProvider;

    /**
     * @var DefinitionResponseFactoryInterface[]
     */
    private array $definitionResponseFactories = [];

    /**
     * @var ProcedureProcessorInterface
     */
    private ProcedureProcessorInterface $procedureProcessor;

    /**
     * @param string $contentType
     * @param DefinitionResponseFactoryInterface $factory
     */
    public function addDefinitionResponseFactory(
        string $contentType,
        DefinitionResponseFactoryInterface $factory
    ): void {
        $this->definitionResponseFactories[strtolower($contentType)] = $factory;
    }

    /**
     * @param string $contentType
     * @return DefinitionResponseFactoryInterface
     */
    protected function getDefinitionResponseFactory(string $contentType): DefinitionResponseFactoryInterface
    {
        $key = strtolower($contentType);
        if (!array_key_exists($key, $this->definitionResponseFactories)) {
            throw new UnregisteredContentTypeException($contentType);
        }

        return $this->definitionResponseFactories[$key];
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handleRequest(RequestInterface $request): ResponseInterface
    {
        switch ($this->parseFirstPartFromUri($request->getUri())) {
            case '_documentation':
                return $this->handleDocumentationRequest($request);
            case '_packages':
                return $this->handlePackagesRequest($request);
            case '_schema':
                return $this->handleSchemaRequest($request);
            case '_transactions':
                return $this->handleTransactionsRequest($request);
            case '@files':
                return $this->handleFileRequest($request);
            default:
                return $this->handleProcedureRequest($request);
        }

        //@todo try-catch and then response for throwable
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handlePackagesRequest(RequestInterface $request): ResponseInterface
    {
        $contentType = $this->parseContentTypeFromUri($request->getUri());

        return $this->getDefinitionResponseFactory($contentType)->createPackagesResponse(
            $this->definitionProvider->getPackageDefinitions()
        );
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handleSchemaRequest(RequestInterface $request): ResponseInterface
    {
        $contentType = $this->parseContentTypeFromUri($request->getUri());

        $schemaName = $this->parseSecondPartFromUri($request->getUri());

        return $this->getDefinitionResponseFactory($contentType)->createSchemaResponse(
            $this->definitionProvider->getSchemaDefinition($schemaName)
        );
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function handleDocumentationRequest(RequestInterface $request): ResponseInterface
    {
        $contentType = $this->parseContentTypeFromUri($request->getUri());

        return $this->getDefinitionResponseFactory($contentType)->createDocumentationResponse(
            $this->definitionProvider->getApplicationDefinition()
        );
    }

    public function handleProcedureRequest(RequestInterface $request): ResponseInterface
    {
        $transaction = $this->createTransaction(
            '',//@todo create uuid
            [$this->parseProcedureFromRequest($request)]
        );

        $result = $this->executeTransaction($transaction);

        $result->getProcedureResults()[0];

        //@todo response
    }

    public function handleTransactionsRequest(RequestInterface $request): ResponseInterface
    {
        $transactions = $this->parseTransactionsFromRequest($request);

        $transactionResults = [];
        foreach ($transactions as $transaction) {
            $transactionResults[] = $this->executeTransaction($transaction);
        }

        //@todo response
    }

    public function handleFileRequest(RequestInterface $request): ResponseInterface
    {
    }

    /**
     * @param UriInterface $uri
     * @return string
     */
    protected function parseEndpointPathFromUri(UriInterface $uri): string
    {
        $path = $uri->getPath();

        // remove content type from path
        $parts = explode('.', $path);
        if (count($parts) > 1) {
            array_pop($parts);
        }
        $path = implode('.', $parts);

        $matches = [];
        preg_match('/(elliRPC\/)(.*)/', $path, $matches);

        if (!array_key_exists(2, $matches)) {
            //@todo exception
        }

        return $matches[2];
    }

    /**
     * @param UriInterface $uri
     * @return string
     */
    protected function parseFirstPartFromUri(UriInterface $uri): string
    {
        return explode('/', $this->parseEndpointPathFromUri($uri))[0];
    }

    /**
     * @param UriInterface $uri
     * @return string|null
     */
    protected function parseSecondPartFromUri(UriInterface $uri): ?string
    {
        $parts = explode('/', $this->parseEndpointPathFromUri($uri), 2);

        if (count($parts) < 2) {
            return null;
        }

        return end($parts);
    }

    /**
     * @param UriInterface $uri
     * @return string
     */
    protected function parseContentTypeFromUri(UriInterface $uri): string
    {
        $parts = explode('.', $uri->getPath());

        return end($parts);
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws Throwable
     */
    protected function parseProcedureFromRequest(RequestInterface $request): array
    {
        $procedure = [];
        $procedure['procedureId'] = '';//@todo create uuid
        $procedure['package'] = $this->parseFirstPartFromUri($request->getUri());
        $procedure['procedure'] = $this->parseSecondPartFromUri($request->getUri());

        parse_str($request->getUri()->getQuery(), $procedure);

        if (!array_key_exists('pagination', $procedure) || !is_array($procedure['pagination'])) {
            $procedure['pagination'] = [];
        }

        if (!array_key_exists('sort', $procedure) || !is_string($procedure['sort'])) {
            $procedure['sort'] = null;
        }

        $procedure['data'] = $this->parseProcedureDataFromRequest($request);

        return $procedure;
    }


    /**
     * @param RequestInterface $request
     * @return array|null
     * @throws Throwable
     */
    protected function parseProcedureDataFromRequest(RequestInterface $request): array
    {
        $data = [];

        $query = [];
        parse_str($request->getUri()->getQuery(), $query);
        if (array_key_exists('data', $query) && is_array($query['data'])) {
            $data = $query['data'];
        }

        $dataString = $request->getBody()->getContents();
        if (empty($dataString)) {
            return $data;
        }

        $contentTypeHeader = $request->getHeader('Content-Type');
        if (empty($contentTypeHeader)) {
            throw new MissingContentTypeException();
        }

        $parsedData = [];
        switch ($contentTypeHeader[0]) {
            case 'application/json':
            case 'application/ld+json':
                $parsedData = json_decode($dataString, true, 512, JSON_THROW_ON_ERROR);
                break;
            case 'application/x-www-form-urlencoded':
                parse_str($dataString, $parsedData);
                break;
            case'multipart/form-data':
                //@todo
                break;
            default:
                throw new UnsupportedContentTypeException($contentTypeHeader[0]);
        }

        return $parsedData;
    }

    /**
     * @param RequestInterface $request
     * @return Transaction[]
     * @throws Throwable
     */
    protected function parseTransactionsFromRequest(RequestInterface $request): array
    {
        $contentTypeHeader = $request->getHeader('Content-Type');
        if (empty($contentTypeHeader)) {
            throw new MissingContentTypeException();
        }
        if (!in_array($contentTypeHeader[0], ['application/json', 'application/ld+json'], true)) {
            throw new UnsupportedContentTypeException($contentTypeHeader[0]);
        }

        $dataString = $request->getBody()->getContents();
        if (empty($dataString)) {
            return [];
        }

        $transactions = [];

        $parsedDataString = json_decode($dataString, true, 512, JSON_THROW_ON_ERROR);
        foreach ($parsedDataString['transactions'] as $id => $procedures) {
            $transactions[] = $this->createTransaction($id, $procedures);
        }

        return $transactions;
    }

    protected function createTransaction(string $id, array $procedures): Transaction
    {
        $procedureObjects = [];
        foreach ($procedures as $procedure) {
            $procedureObjects[] = $this->createProcedure($procedure);
        }

        //@todo create event for transaction parsed/created

        return new Transaction($id, $procedureObjects);
    }

    /**
     * @param array $procedure
     * @return Procedure
     */
    protected function createProcedure(array $procedure): Procedure
    {
        //@todo create event for procedure parsed/created
        return new Procedure(
            $procedure['procedureId'],
            $procedure['package'],
            $procedure['procedure'],
            $procedure['data'],
            $procedure['pagination'],
            $procedure['sorting']
        );
    }

    /**
     * @param Transaction $transaction
     * @return TransactionResult
     */
    protected function executeTransaction(Transaction $transaction): TransactionResult
    {
        //@todo event for transaction start

        $procedureResults = [];
        foreach ($transaction->getProcedures() as $procedure) {
            //@todo event for procedure execution start
            $procedureResults[] = $this->procedureProcessor->execute($procedure);
            //@todo event for procedure execution end
        }

        $transactionResult = new TransactionResult($transaction, $procedureResults);
        //@todo event for transaction end

        return $transactionResult;
    }
}

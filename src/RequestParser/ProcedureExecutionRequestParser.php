<?php

namespace Ellinaut\ElliRPC\RequestParser;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\ProcedureExecutionContext;
use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\DataTransfer\ProcedureBody;
use Ellinaut\ElliRPC\DataTransfer\ProcedureDefinition;
use Ellinaut\ElliRPC\DataTransfer\Request\AbstractRequest;
use Ellinaut\ElliRPC\DataTransfer\Request\ProcedureExecutionRequest;
use Ellinaut\ElliRPC\Exception\InvalidContentTypeHeaderException;
use Psr\Http\Message\RequestInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureExecutionRequestParser extends AbstractRequestParser
{
    /**
     * @param RequestInterface $request
     * @return AbstractRequest|null
     * @throws Throwable
     */
    public function parseRequest(RequestInterface $request): ?AbstractRequest
    {
        // only http methods GET and POST are allowed for definitions requests
        if (!in_array(strtoupper($request->getMethod()), ['GET', 'POST'], true)) {
            return null;
        }

        $endpoint = $this->parseEndpointFromUri($request->getUri());
        if ($endpoint !== '@procedures') {
            return null;
        }

        [$packageName, $procedureName] = explode('/', $this->parseAdjustedPathFromUri($request->getUri()));
        if (!$packageName || !$procedureName) {
            return null;
        }

        $procedureDefinition = new ProcedureDefinition($packageName, $procedureName);

        $query = $this->parseQueryFromUri($request->getUri());

        return new ProcedureExecutionRequest(
            new ProcedureExecutionContext(
                $this->parseContentTypeExtensionFromUri($request->getUri()),
                $request->getHeader('Accept'),
                $procedureDefinition

            ),
            new Procedure(
                $procedureDefinition,
                new ProcedureBody(
                    $query['pagination'] ?? null,
                    $query['sorting'] ?? null,
                    $this->parseProcedureDataFromRequest($request),
                )
            ),
            $request->getHeaders()
        );
    }

    /**
     * @param RequestInterface $request
     * @return array
     * @throws Throwable
     */
    protected function parseProcedureDataFromRequest(RequestInterface $request): array
    {
        $requestBody = trim($request->getBody()->getContents());
        if (empty($requestBody)) {
            $query = $this->parseQueryFromUri($request->getUri());

            return $query['data'] ?? [];
        }

        $contentTypeHeader = $request->getHeaderLine('Content-Type');
        if (empty($contentTypeHeader)) {
            throw new InvalidContentTypeHeaderException();
        }

        switch ($contentTypeHeader) {
            case 'application/json':
                return json_decode($requestBody, true, 512, JSON_THROW_ON_ERROR);
            case 'application/x-www-form-urlencoded':
                $parsedData = [];
                parse_str($requestBody, $parsedData);
                return $parsedData;
            case'multipart/form-data':
                //@todo
//                return [];
        }

        throw new InvalidContentTypeHeaderException();
    }

}

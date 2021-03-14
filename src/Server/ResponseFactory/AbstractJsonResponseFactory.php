<?php

namespace Ellinaut\ElliRPC\Server\ResponseFactory;

use JsonException;
use Psr\Http\Message\ResponseInterface;

/**
 * @author Philipp Marien
 */
abstract class AbstractJsonResponseFactory extends AbstractResponseFactory
{
    /**
     * @param array $data
     * @param int $httpStatusCode
     * @return ResponseInterface
     * @throws JsonException
     */
    protected function createJsonResponse(array $data, int $httpStatusCode = 200): ResponseInterface
    {
        $response = $this->createResponseWithBody(json_encode($data, JSON_THROW_ON_ERROR), $httpStatusCode);

        return $response->withHeader('Content-Type', 'application/json');
    }
}

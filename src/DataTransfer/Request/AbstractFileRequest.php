<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

/**
 * @author Philipp Marien
 */
abstract class AbstractFileRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private string $publicFileLocation;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param string $publicFileLocation
     */
    public function __construct(array $headers, string $requestedContentType, string $publicFileLocation)
    {
        parent::__construct($headers, $requestedContentType);
        $this->publicFileLocation = $publicFileLocation;
    }

    /**
     * @return string
     */
    public function getPublicFileLocation(): string
    {
        return $this->publicFileLocation;
    }
}

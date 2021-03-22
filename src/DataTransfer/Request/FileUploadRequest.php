<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

/**
 * @author Philipp Marien
 */
class FileUploadRequest extends AbstractFileRequest
{
    /**
     * @var string
     */
    private string $fileContent;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param string $publicFileLocation
     * @param string $fileContent
     */
    public function __construct(
        array $headers,
        string $requestedContentType,
        string $publicFileLocation,
        string $fileContent
    ) {
        parent::__construct($headers, $requestedContentType, $publicFileLocation);
        $this->fileContent = $fileContent;
    }

    /**
     * @return string
     */
    public function getFileContent(): string
    {
        return $this->fileContent;
    }
}

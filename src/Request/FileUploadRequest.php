<?php

namespace Ellinaut\ElliRPC\Request;

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
     * @param string $fileName
     * @param string|null $directoryPath
     * @param string $fileContent
     */
    public function __construct(
        array $headers,
        string $requestedContentType,
        string $fileName,
        ?string $directoryPath,
        string $fileContent
    ) {
        parent::__construct($headers, $requestedContentType, $fileName, $directoryPath);
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

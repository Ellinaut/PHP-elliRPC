<?php

namespace Ellinaut\ElliRPC\Request;

/**
 * @author Philipp Marien
 */
abstract class AbstractFileRequest extends AbstractRequest
{
    /**
     * @var string
     */
    private string $fileName;

    /***
     * @var string|null
     */
    private ?string $directoryPath;

    /**
     * @param string[][] $headers
     * @param string $requestedContentType
     * @param string $fileName
     * @param string|null $directoryPath
     */
    public function __construct(array $headers, string $requestedContentType, string $fileName, ?string $directoryPath)
    {
        parent::__construct($headers, $requestedContentType);
        $this->fileName = $fileName;
        $this->directoryPath = $directoryPath;
    }

    /**
     * @return string
     */
    public function getFileName(): string
    {
        return $this->fileName;
    }

    /**
     * @return string|null
     */
    public function getDirectoryPath(): ?string
    {
        return $this->directoryPath;
    }
}

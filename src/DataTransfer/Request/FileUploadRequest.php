<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

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
     * @param AbstractFormattingContext $context
     * @param string $publicFileLocation
     * @param string $fileContent
     * @param string[][] $requestHeaders
     */
    public function __construct(
        AbstractFormattingContext $context,
        string $publicFileLocation,
        string $fileContent,
        array $requestHeaders = []
    ) {
        parent::__construct($context, $publicFileLocation, $requestHeaders);
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

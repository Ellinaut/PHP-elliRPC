<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

/**
 * @author Philipp Marien
 */
class File extends FileReference
{
    /**
     * @var string
     */
    private string $mimeType;

    /**
     * @var string
     */
    private string $content;

    /**
     * @param string $contentLocationValue
     * @param string $mimeType
     * @param string $content
     */
    public function __construct(string $contentLocationValue, string $mimeType, string $content)
    {
        parent::__construct($contentLocationValue);
        $this->mimeType = $mimeType;
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }
}

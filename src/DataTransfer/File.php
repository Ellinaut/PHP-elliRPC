<?php

namespace Ellinaut\ElliRPC\DataTransfer;

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
     * @param string $publicLocation
     * @param string $mimeType
     * @param string $content
     */
    public function __construct(string $publicLocation, string $mimeType, string $content)
    {
        parent::__construct($publicLocation);
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

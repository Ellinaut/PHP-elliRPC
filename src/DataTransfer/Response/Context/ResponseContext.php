<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response\Context;

/**
 * @author Philipp Marien
 */
abstract class ResponseContext
{
    /**
     * @var string
     */
    private string $contentType;

    /**
     * @param string $contentType
     */
    public function __construct(string $contentType)
    {
        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }
}

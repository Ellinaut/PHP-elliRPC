<?php

namespace Ellinaut\ElliRPC\DataTransfer\FormattingContext;

/**
 * @author Philipp Marien
 */
abstract class AbstractFormattingContext
{
    /**
     * @var string
     */
    private string $contentTypeExtension;

    /**
     * @var string[]
     */
    private array $acceptedHeader;

    /**
     * @param string $contentTypeExtension
     * @param string[] $acceptedHeader
     */
    public function __construct(string $contentTypeExtension, array $acceptedHeader)
    {
        $this->contentTypeExtension = $contentTypeExtension;
        $this->acceptedHeader = $acceptedHeader;
    }

    /**
     * @return string
     */
    public function getContentTypeExtension(): string
    {
        return $this->contentTypeExtension;
    }

    /**
     * @return string[]
     */
    public function getAcceptedHeader(): array
    {
        return $this->acceptedHeader;
    }
}

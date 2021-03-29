<?php

namespace Ellinaut\ElliRPC\DataTransfer\Request;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

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
     * @param AbstractFormattingContext $context
     * @param string $publicFileLocation
     * @param string[][] $requestHeaders
     */
    public function __construct(
        AbstractFormattingContext $context,
        string $publicFileLocation,
        array $requestHeaders = []
    ) {
        parent::__construct($context, $requestHeaders);
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

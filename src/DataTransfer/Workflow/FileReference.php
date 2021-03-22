<?php

namespace Ellinaut\ElliRPC\DataTransfer\Workflow;

/**
 * @author Philipp Marien
 */
class FileReference
{
    /**
     * @var string
     */
    private string $contentLocationValue;


    /**
     * @param string $contentLocationValue
     */
    public function __construct(string $contentLocationValue)
    {
        $this->contentLocationValue = $contentLocationValue;
    }

    /**
     * @return string
     */
    public function getContentLocationValue(): string
    {
        return $this->contentLocationValue;
    }
}

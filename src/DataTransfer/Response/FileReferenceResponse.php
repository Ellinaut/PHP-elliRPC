<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FileReference;
use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;

/**
 * @author Philipp Marien
 */
class FileReferenceResponse extends AbstractFormatableResponse
{
    /**
     * @var FileReference
     */
    private FileReference $content;

    /**
     * @param AbstractFormattingContext $context
     * @param FileReference $content
     */
    public function __construct(AbstractFormattingContext $context, FileReference $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return FileReference
     */
    public function getContent(): FileReference
    {
        return $this->content;
    }
}

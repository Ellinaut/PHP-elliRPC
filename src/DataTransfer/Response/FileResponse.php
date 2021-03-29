<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\FormattingContext\AbstractFormattingContext;
use Ellinaut\ElliRPC\DataTransfer\File;

/**
 * @author Philipp Marien
 */
class FileResponse extends AbstractFormatableResponse
{
    /**
     * @var File
     */
    private File $content;

    /**
     * @param AbstractFormattingContext $context
     * @param File $content
     */
    public function __construct(AbstractFormattingContext $context, File $content)
    {
        parent::__construct($context);
        $this->content = $content;
    }

    /**
     * @return File
     */
    public function getContent(): File
    {
        return $this->content;
    }
}

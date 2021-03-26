<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Workflow\File;

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
     * @param AbstractResponseContext $context
     * @param File $content
     */
    public function __construct(AbstractResponseContext $context, File $content)
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

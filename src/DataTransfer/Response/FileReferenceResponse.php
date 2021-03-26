<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\AbstractResponseContext;
use Ellinaut\ElliRPC\DataTransfer\Workflow\FileReference;

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
     * @param AbstractResponseContext $context
     * @param FileReference $content
     */
    public function __construct(AbstractResponseContext $context, FileReference $content)
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

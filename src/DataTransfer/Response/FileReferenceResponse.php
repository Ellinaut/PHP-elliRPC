<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response;

use Ellinaut\ElliRPC\DataTransfer\Response\Context\ResponseContext;
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
     * @param ResponseContext $context
     * @param FileReference $content
     */
    public function __construct(ResponseContext $context, FileReference $content)
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

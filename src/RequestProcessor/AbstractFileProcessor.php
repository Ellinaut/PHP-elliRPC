<?php

namespace Ellinaut\ElliRPC\RequestProcessor;

use Ellinaut\ElliRPC\FileHandler\FileHandlerInterface;

/**
 * @author Philipp Marien
 */
abstract class AbstractFileProcessor implements RequestProcessorInterface
{
    /**
     * @var FileHandlerInterface
     */
    private FileHandlerInterface $fileHandler;

    /**
     * @param FileHandlerInterface $fileHandler
     */
    public function __construct(FileHandlerInterface $fileHandler)
    {
        $this->fileHandler = $fileHandler;
    }

    /**
     * @return FileHandlerInterface
     */
    protected function getFileHandler(): FileHandlerInterface
    {
        return $this->fileHandler;
    }
}

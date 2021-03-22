<?php

namespace Ellinaut\ElliRPC\FileHandler;

use Ellinaut\ElliRPC\DataTransfer\Workflow\File;
use Ellinaut\ElliRPC\DataTransfer\Workflow\FileReference;

/**
 * @author Philipp Marien
 */
interface FileHandlerInterface
{
    /**
     * @param string $publicLocation
     * @param string $content
     * @return FileReference
     */
    public function createFile(string $publicLocation, string $content): FileReference;

    /**
     * @param string $publicLocation
     * @param string $content
     * @return FileReference
     */
    public function replaceFile(string $publicLocation, string $content): FileReference;

    /**
     * @param string $publicLocation
     * @return File
     */
    public function readFile(string $publicLocation): File;

    /**
     * @param string $publicLocation
     */
    public function deleteFile(string $publicLocation): void;
}

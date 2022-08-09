<?php

namespace Ellinaut\ElliRPC\File;

use Ellinaut\ElliRPC\Exception\UnsupportedFilesystemException;
use SplFileInfo;

/**
 * @author Philipp Marien
 */
class UnsupportedFilesystem implements FilesystemInterface
{
    /**
     * @param string $storagePath
     * @return SplFileInfo|null
     * @throws UnsupportedFilesystemException
     */
    public function loadFile(string $storagePath): ?SplFileInfo
    {
        throw new UnsupportedFilesystemException('Loading files is not supported.');
    }

    /**
     * @param string $storagePath
     * @param string $content
     * @return void
     * @throws UnsupportedFilesystemException
     */
    public function storeFile(string $storagePath, string $content): void
    {
        throw new UnsupportedFilesystemException('Storing files is not supported.');
    }

    /**
     * @param string $storagePath
     * @return void
     * @throws UnsupportedFilesystemException
     */
    public function deleteFile(string $storagePath): void
    {
        throw new UnsupportedFilesystemException('Deleting files is not supported.');
    }
}

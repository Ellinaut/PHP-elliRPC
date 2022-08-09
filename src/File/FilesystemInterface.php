<?php

namespace Ellinaut\ElliRPC\File;

use SplFileInfo;

/**
 * @author Philipp Marien
 */
interface FilesystemInterface
{
    public function loadFile(string $storagePath): ?SplFileInfo;

    public function storeFile(string $storagePath, string $content): void;

    public function deleteFile(string $storagePath): void;
}

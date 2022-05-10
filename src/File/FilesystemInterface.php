<?php

namespace Ellinaut\ElliRPC\File;

use SplFileInfo;

/**
 * @author Philipp Marien
 */
interface FilesystemInterface
{
    public function loadFile(string $realPath): ?SplFileInfo;

    public function storeFile(string $realPath, string $content): void;

    public function deleteFile(string $realPath): void;
}

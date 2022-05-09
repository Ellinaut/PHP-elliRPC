<?php

namespace Ellinaut\ElliRPC\File;

use SplFileInfo;

/**
 * @author Philipp Marien
 */
interface FilesystemInterface
{
    public function loadFile(string $realPath): ?SplFileInfo;

    public function storeFile(string $realPath, string $content, bool $allowOverwrite): void;

    public function deleteFile(string $realPath): void;
}

<?php

namespace Ellinaut\ElliRPC\File\Bridge;

use Ellinaut\ElliRPC\File\FilesystemInterface;
use SplFileInfo;
use Symfony\Component\Filesystem\Filesystem;

/**
 * @author Philipp Marien
 */
class SymfonyFilesystem implements FilesystemInterface
{
    public function __construct(private readonly Filesystem $filesystem)
    {
    }

    /**
     * @param string $realPath
     * @return SplFileInfo|null
     */
    public function loadFile(string $realPath): ?SplFileInfo
    {
        if ($this->filesystem->exists($realPath)) {
            return new SplFileInfo($realPath);
        }

        return null;
    }

    /**
     * @param string $realPath
     * @param string $content
     * @param bool $allowOverwrite
     * @return void
     */
    public function storeFile(string $realPath, string $content, bool $allowOverwrite): void
    {
        $exists = $this->filesystem->exists($realPath);
        if ($exists && !$allowOverwrite) {
            //@todo exception
        }

        if ($exists) {
            $this->filesystem->remove($realPath);
        }

        $this->filesystem->dumpFile($realPath, $content);
    }

    /**
     * @param string $realPath
     * @return void
     */
    public function deleteFile(string $realPath): void
    {
        $this->filesystem->remove($realPath);
    }
}

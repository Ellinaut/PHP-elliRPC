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
     * @param string $storagePath
     * @return SplFileInfo|null
     */
    public function loadFile(string $storagePath): ?SplFileInfo
    {
        if ($this->filesystem->exists($storagePath)) {
            return new SplFileInfo($storagePath);
        }

        return null;
    }

    /**
     * @param string $storagePath
     * @param string $content
     * @return void
     */
    public function storeFile(string $storagePath, string $content): void
    {
        $exists = $this->filesystem->exists($storagePath);
        if ($exists) {
            $this->filesystem->remove($storagePath);
        }

        $this->filesystem->dumpFile($storagePath, $content);
    }

    /**
     * @param string $storagePath
     * @return void
     */
    public function deleteFile(string $storagePath): void
    {
        $this->filesystem->remove($storagePath);
    }
}

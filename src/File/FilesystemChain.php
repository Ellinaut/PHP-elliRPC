<?php

namespace Ellinaut\ElliRPC\File;

use SplFileInfo;

/**
 * @author Philipp Marien
 */
class FilesystemChain implements FilesystemInterface
{
    /**
     * @var ChainableFilesystem[]
     */
    private array $filesystems = [];

    public function __construct(private readonly FilesystemInterface $fallback)
    {
    }

    public function add(ChainableFilesystem $filesystem): void
    {
        $this->filesystems[] = $filesystem;
    }

    /**
     * @param string $storagePath
     * @return SplFileInfo|null
     */
    public function loadFile(string $storagePath): ?SplFileInfo
    {
        return $this->selectFilesystem($storagePath)->loadFile($storagePath);
    }

    /**
     * @param string $storagePath
     * @param string $content
     * @return void
     */
    public function storeFile(string $storagePath, string $content): void
    {
        $this->selectFilesystem($storagePath)->storeFile($storagePath, $content);
    }

    /**
     * @param string $storagePath
     * @return void
     */
    public function deleteFile(string $storagePath): void
    {
        $this->selectFilesystem($storagePath)->deleteFile($storagePath);
    }

    protected function selectFilesystem(string $path): FilesystemInterface
    {
        foreach ($this->filesystems as $filesystem) {
            if ($filesystem->supportsStoragePath($path)) {
                return $filesystem;
            }
        }

        return $this->fallback;
    }
}

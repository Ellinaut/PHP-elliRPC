<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
class FileLocatorChain implements FileLocatorInterface
{
    /**
     * @var ChainableFileLocator[]
     */
    private array $fileLocators = [];

    public function __construct(private readonly FileLocatorInterface $fallback)
    {
    }

    public function add(ChainableFileLocator $fileLocator): void
    {
        $this->fileLocators[] = $fileLocator;
    }

    /**
     * @param string $storagePath
     * @return string
     */
    public function resolvePublicPath(string $storagePath): string
    {
        return $this->selectRealPathLocator($storagePath)->resolvePublicPath($storagePath);
    }

    /**
     * @param string $storagePath
     * @return string
     */
    public function resolvePublicName(string $storagePath): string
    {
        return $this->selectRealPathLocator($storagePath)->resolvePublicName($storagePath);
    }

    /**
     * @param string $publicPath
     * @return string
     */
    public function resolveStoragePath(string $publicPath): string
    {
        return $this->selectRPCPathLocator($publicPath)->resolveStoragePath($publicPath);
    }

    protected function selectRPCPathLocator(string $path): FileLocatorInterface
    {
        foreach ($this->fileLocators as $fileLocator) {
            if ($fileLocator->supportsPublicPath($path)) {
                return $fileLocator;
            }
        }

        return $this->fallback;
    }

    protected function selectRealPathLocator(string $path): FileLocatorInterface
    {
        foreach ($this->fileLocators as $fileLocator) {
            if ($fileLocator->supportsStoragePath($path)) {
                return $fileLocator;
            }
        }

        return $this->fallback;
    }
}

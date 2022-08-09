<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
class LocalPathLocator implements FileLocatorInterface
{
    public function __construct(
        private readonly string $localPath
    ) {
    }

    /**
     * @param string $storagePath
     * @return string
     */
    public function resolvePublicPath(string $storagePath): string
    {
        return '/' . ltrim(str_replace($this->localPath, '', $storagePath), '/');
    }

    /**
     * @param string $storagePath
     * @return string
     */
    public function resolvePublicName(string $storagePath): string
    {
        $parts = explode('/', $storagePath);

        return $parts[array_key_last($parts)];
    }

    /**
     * @param string $publicPath
     * @return string
     */
    public function resolveStoragePath(string $publicPath): string
    {
        return rtrim($this->localPath, '/') . '/' . ltrim($publicPath, '/');
    }
}

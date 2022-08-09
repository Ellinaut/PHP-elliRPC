<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
class UnresolvedFileLocator implements FileLocatorInterface
{
    /**
     * @param string $storagePath
     * @return string
     */
    public function resolvePublicPath(string $storagePath): string
    {
        return $storagePath;
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
        return $publicPath;
    }
}

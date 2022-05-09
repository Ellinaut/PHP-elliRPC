<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
class DefaultFileLocator implements FileLocatorInterface
{
    public function __construct(
        private readonly string $localBasePath
    ) {
    }

    /**
     * @param string $realPath
     * @return string
     */
    public function resolveRPCPath(string $realPath): string
    {
        return '/' . ltrim(str_replace($this->localBasePath, '', $realPath), '/');
    }

    /**
     * @param string $realPath
     * @return string
     */
    public function resolveRPCName(string $realPath): string
    {
        $parts = explode('/', $realPath);

        return $parts[array_key_last($parts)];
    }

    /**
     * @param string $rpcPath
     * @return string
     */
    public function resolveRealPath(string $rpcPath): string
    {
        return rtrim($this->localBasePath, '/') . '/' . ltrim($rpcPath, '/');
    }
}

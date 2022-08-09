<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
interface ChainableFileLocator extends FileLocatorInterface
{
    public function supportsStoragePath(string $storagePath): bool;

    public function supportsPublicPath(string $publicPath): bool;
}

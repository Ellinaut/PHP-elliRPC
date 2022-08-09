<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
interface ChainableFilesystem extends FilesystemInterface
{
    public function supportsStoragePath(string $storagePath): bool;
}

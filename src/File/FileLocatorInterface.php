<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
interface FileLocatorInterface
{
    public function resolvePublicPath(string $storagePath): string;

    public function resolvePublicName(string $storagePath): string;

    public function resolveStoragePath(string $publicPath): string;
}

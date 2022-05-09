<?php

namespace Ellinaut\ElliRPC\File;

/**
 * @author Philipp Marien
 */
interface FileLocatorInterface
{
    public function resolveRPCPath(string $realPath): string;

    public function resolveRPCName(string $realPath): string;

    public function resolveRealPath(string $rpcPath): string;
}

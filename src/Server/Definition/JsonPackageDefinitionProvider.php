<?php

namespace Ellinaut\ElliRPC\Server\Definition;

use Ellinaut\ElliRPC\Definition\Factory\PackageDefinitionFactoryInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class JsonPackageDefinitionProvider extends ArrayPackageDefinitionProvider
{
    /**
     * @param PackageDefinitionFactoryInterface $packageDefinitionFactory
     * @param string $packages
     * @throws Throwable
     */
    public function __construct(PackageDefinitionFactoryInterface $packageDefinitionFactory, string $packages)
    {
        parent::__construct(
            $packageDefinitionFactory,
            json_decode($packages, true, 512, JSON_THROW_ON_ERROR)['packages']
        );
    }
}

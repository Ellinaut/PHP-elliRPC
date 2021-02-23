<?php

namespace Ellinaut\ElliRPC\Server\Definition;

use Ellinaut\ElliRPC\Definition\Factory\PackageDefinitionFactoryInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\Provider\PackageDefinitionProviderInterface;

/**
 * @author Philipp Marien
 */
class ArrayPackageDefinitionProvider implements PackageDefinitionProviderInterface
{
    /**
     * @var PackageDefinitionFactoryInterface
     */
    private PackageDefinitionFactoryInterface $packageDefinitionFactory;

    /**
     * @var array
     */
    private array $packages;

    /**
     * @var PackageDefinitionInterface[]|null
     */
    private ?array $packageDefinitions;

    /**
     * @param PackageDefinitionFactoryInterface $packageDefinitionFactory
     * @param array $packages
     */
    public function __construct(PackageDefinitionFactoryInterface $packageDefinitionFactory, array $packages)
    {
        $this->packageDefinitionFactory = $packageDefinitionFactory;
        $this->packages = $packages;
    }

    /**
     * @return PackageDefinitionInterface[]
     */
    public function getPackageDefinitions(): array
    {
        if (!is_array($this->packageDefinitions)) {
            $this->packageDefinitions = [];
            foreach ($this->packages as $packageName => $packageDefinition) {
                $this->packageDefinitions[] = $this->packageDefinitionFactory->createDefinition(
                    $packageName,
                    $packageDefinition
                );
            }
        }

        return $this->packageDefinitions;
    }
}

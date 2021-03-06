<?php

namespace Ellinaut\ElliRPC\Server\Formatter;

use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;

/**
 * @author Philipp Marien
 */
interface PackageDefinitionFormatterInterface
{
    /**
     * @param PackageDefinitionInterface[] $packageDefinitions
     * @return string
     */
    public function format(array $packageDefinitions): string;
}

<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class PackageNotFoundException extends NotFoundException
{
    /**
     * @param string $package
     */
    public function __construct(string $package)
    {
        parent::__construct('The server isn\'t able to find a package with name "' . $package . '".', 20210331132753);
    }
}

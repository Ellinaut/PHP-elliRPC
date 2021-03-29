<?php

namespace Ellinaut\ElliRPC\DataTransfer;

/**
 * @author Philipp Marien
 */
class FileReference
{
    /**
     * @var string
     */
    private string $publicLocation;


    /**
     * @param string $publicLocation
     */
    public function __construct(string $publicLocation)
    {
        $this->publicLocation = $publicLocation;
    }

    /**
     * @return string
     */
    public function getPublicLocation(): string
    {
        return $this->publicLocation;
    }
}

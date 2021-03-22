<?php

namespace Ellinaut\ElliRPC\DataTransfer\Response\Context;

/**
 * @author Philipp Marien
 */
class ProcedureResponseContext extends ResponseContext
{
    /**
     * @var string
     */
    private string $package;

    /**
     * @var string
     */
    private string $procedure;

    /**
     * @param string $contentType
     */
    public function __construct(string $contentType, string $package, string $procedure)
    {
        parent::__construct($contentType);
        $this->package = $package;
        $this->procedure = $procedure;
    }

    /**
     * @return string
     */
    public function getPackage(): string
    {
        return $this->package;
    }

    /**
     * @return string
     */
    public function getProcedure(): string
    {
        return $this->procedure;
    }
}

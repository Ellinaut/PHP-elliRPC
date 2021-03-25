<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
interface StatusProvidingExceptionInterface
{
    /**
     * @return int
     */
    public function getHttpStatusCode(): int;
}

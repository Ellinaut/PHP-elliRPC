<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
interface ContextProvidingExceptionInterface
{
    /**
     * @return array
     */
    public function getContext(): array;
}

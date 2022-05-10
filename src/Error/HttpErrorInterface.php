<?php

namespace Ellinaut\ElliRPC\Error;

/**
 * @author Philipp Marien
 */
interface HttpErrorInterface
{
    public function getStatusCode(): int;
}

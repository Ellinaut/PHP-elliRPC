<?php

namespace Ellinaut\ElliRPC\Error\Factory;

use Ellinaut\ElliRPC\Error\Error;
use Throwable;

/**
 * @author Philipp Marien
 */
interface ErrorFactoryInterface
{
    public function createFromThrowable(Throwable $throwable): ?Error;
}

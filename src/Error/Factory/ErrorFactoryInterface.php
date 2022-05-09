<?php

namespace Ellinaut\ElliRPC\Error\Factory;

use Ellinaut\ElliRPC\Value\Error;
use Throwable;

/**
 * @author Philipp Marien
 */
interface ErrorFactoryInterface
{
    public function createFromThrowable(Throwable $throwable): ?Error;
}

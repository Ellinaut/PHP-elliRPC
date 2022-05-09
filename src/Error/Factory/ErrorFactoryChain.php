<?php

namespace Ellinaut\ElliRPC\Error\Factory;

use Ellinaut\ElliRPC\Value\Error;
use Throwable;

/**
 * @author Philipp Marien
 */
class ErrorFactoryChain implements ErrorFactoryInterface
{
    /**
     * @var ErrorFactoryInterface[]
     */
    private array $factories = [];

    public function register(ErrorFactoryInterface $factory): void
    {
        $this->factories[] = $factory;
    }

    /**
     * @param Throwable $throwable
     * @return Error|null
     */
    public function createFromThrowable(Throwable $throwable): ?Error
    {
        foreach ($this->factories as $factory) {
            $error = $factory->createFromThrowable($throwable);
            if ($error) {
                return $error;
            }
        }

        return null;
    }
}

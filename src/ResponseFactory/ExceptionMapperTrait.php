<?php

namespace Ellinaut\ElliRPC\ResponseFactory;

use Ellinaut\ElliRPC\Exception\ContextProvidingExceptionInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
trait ExceptionMapperTrait
{
    /**
     * @param Throwable $exception
     * @return array
     */
    protected function mapException(Throwable $exception): array
    {
        $context = [];
        if ($exception instanceof ContextProvidingExceptionInterface) {
            $context = $exception->getContext();
        }

        return [
            'message' => $exception->getMessage(),
            'code' => $exception->getCode(),
            'context' => $context,
        ];
    }
}

<?php

namespace Ellinaut\ElliRPC\Error\Factory;

use Ellinaut\ElliRPC\Error\Error;
use Ellinaut\ElliRPC\Error\TranslateableHttpError;
use Ellinaut\ElliRPC\Exception\FileExistException;
use Ellinaut\ElliRPC\Exception\FileNotFoundException;
use Throwable;

/**
 * @author Philipp Marien
 */
class FileErrorFactory implements ErrorFactoryInterface
{
    /**
     * @param Throwable $throwable
     * @return Error|null
     */
    public function createFromThrowable(Throwable $throwable): ?Error
    {
        if ($throwable instanceof FileNotFoundException) {
            return new TranslateableHttpError(
                404,
                'en',
                $throwable->getMessage(),
                $throwable->getErrorCode()
            );
        }

        if ($throwable instanceof FileExistException) {
            return new TranslateableHttpError(
                409,
                'en',
                $throwable->getMessage(),
                $throwable->getErrorCode()
            );
        }

        return null;
    }
}

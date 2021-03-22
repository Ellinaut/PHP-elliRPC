<?php

namespace Ellinaut\ElliRPC\Enum;

/**
 * @author Philipp Marien
 */
final class ExecutionStatus extends AbstractEnum
{
    public const EXECUTED = 'executed';

    public const FAILED = 'failed';

    /**
     * @param string $status
     * @return bool
     */
    public static function isSuccessful(string $status): bool
    {
        return $status === self::EXECUTED;
    }
}

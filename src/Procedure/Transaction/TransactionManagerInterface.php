<?php

namespace Ellinaut\ElliRPC\Procedure\Transaction;

/**
 * @author Philipp Marien
 */
interface TransactionManagerInterface
{
    public function registerListener(TransactionListenerInterface $listener): void;

    public function startTransaction(): void;

    public function cancelTransaction(): void;

    public function isTransactionCanceled(): bool;

    public function commitTransaction(): void;

    public function rollbackTransaction(): void;
}

<?php

namespace Ellinaut\ElliRPC\Procedure\Transaction;

/**
 * @author Philipp Marien
 */
interface TransactionListenerInterface
{
    public function onStart(): void;

    public function onCancel(): void;

    public function onCommit(): void;

    public function onRollback(): void;
}

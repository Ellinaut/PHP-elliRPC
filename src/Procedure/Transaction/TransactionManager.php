<?php

namespace Ellinaut\ElliRPC\Procedure\Transaction;

/**
 * @author Philipp Marien
 */
class TransactionManager implements TransactionManagerInterface
{
    /**
     * @var TransactionListenerInterface[]
     */
    private array $listeners = [];

    private bool $canceled = false;

    /**
     * @param TransactionListenerInterface $listener
     * @return void
     */
    public function registerListener(TransactionListenerInterface $listener): void
    {
        $this->listeners[] = $listener;
    }

    /**
     * @return void
     */
    public function startTransaction(): void
    {
        $this->callListeners('onStart');
    }

    /**
     * @return void
     */
    public function cancelTransaction(): void
    {
        $this->canceled = true;
        $this->callListeners('onCancel');
    }

    /**
     * @return bool
     */
    public function isTransactionCanceled(): bool
    {
        return $this->canceled;
    }

    /**
     * @return void
     */
    public function commitTransaction(): void
    {
        $this->callListeners('onCommit');
    }

    /**
     * @return void
     */
    public function rollbackTransaction(): void
    {
        $this->callListeners('onRollback');
    }

    /**
     * @param string $method
     * @return void
     */
    protected function callListeners(string $method): void
    {
        foreach ($this->listeners as $listener) {
            $listener->{$method}();
        }
    }
}

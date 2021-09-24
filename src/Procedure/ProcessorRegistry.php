<?php

namespace Ellinaut\ElliRPC\Procedure;

use Ellinaut\ElliRPC\DataTransfer\Procedure;
use Ellinaut\ElliRPC\Exception\PackageNotFoundException;
use Ellinaut\ElliRPC\Exception\ProcedureNotFoundException;

/**
 * @author Philipp Marien
 */
class ProcessorRegistry implements ProcessorInterface
{
    /**
     * @var ProcessorInterface[][]
     */
    private array $processors = [];

    /**
     * @param ProcessorInterface $processor
     * @param string $package
     * @param string $procedure
     */
    public function register(ProcessorInterface $processor, string $package, string $procedure): void
    {
        $this->processors[$package][$procedure] = $processor;
    }

    /**
     * @param string $transactionId
     * @param Procedure $procedure
     * @return array|null
     */
    public function process(string $transactionId, Procedure $procedure): ?array
    {
        $packageName = $procedure->getDefinition()->getPackageName();
        if (!array_key_exists($packageName, $this->processors)) {
            throw new PackageNotFoundException($packageName);
        }

        $procedureName = $procedure->getDefinition()->getProcedureName();
        if (!array_key_exists($procedureName, $this->processors[$packageName])) {
            throw new ProcedureNotFoundException($packageName, $procedureName);
        }

        return $this->processors[$packageName][$procedureName]->process($transactionId, $procedure);
    }
}

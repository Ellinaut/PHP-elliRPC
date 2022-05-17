<?php

namespace Ellinaut\ElliRPC\Procedure\Processor;

use Ellinaut\ElliRPC\Exception\ProcedureException;
use Ellinaut\ElliRPC\Procedure\ExecutionContext;
use Ellinaut\ElliRPC\Value\ProcedureResult;
use Ellinaut\ElliRPC\Value\RemoteProcedure;

/**
 * @author Philipp Marien
 */
class ProcedureProcessorRegistry implements ProcedureProcessorInterface
{
    /**
     * @var ProcedureProcessorInterface[][]
     */
    private array $processors = [];

    /**
     * @param string $package
     * @param string $procedure
     * @param ProcedureProcessorInterface $processor
     * @return void
     */
    public function register(string $package, string $procedure, ProcedureProcessorInterface $processor): void
    {
        $this->processors[$package][$procedure] = $processor;
    }

    /**
     * @param RemoteProcedure $procedure
     * @param ExecutionContext $context
     * @return ProcedureResult
     * @throws ProcedureException
     */
    public function process(RemoteProcedure $procedure, ExecutionContext $context): ProcedureResult
    {
        if (!array_key_exists($procedure->getPackageName(), $this->processors)) {
            throw new ProcedureException('No processors registered for package "' . $procedure->getPackageName() . '"!');
        }

        if (!array_key_exists($procedure->getProcedureName(), $this->processors[$procedure->getPackageName()])) {
            throw new ProcedureException('No processor registered for procedure "' . $procedure->getProcedureName() . '" in package "' . $procedure->getPackageName() . '"!');
        }

        return $this->processors[$procedure->getPackageName()][$procedure->getProcedureName()]
            ->process($procedure, $context);
    }

}

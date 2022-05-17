<?php

namespace Ellinaut\ElliRPC\Procedure\Validator;

use Ellinaut\ElliRPC\Exception\ProcedureValidationException;
use Ellinaut\ElliRPC\Procedure\ExecutionContext;

/**
 * @author Philipp Marien
 */
interface ProcedureValidatorInterface
{
    /**
     * @param ExecutionContext $context
     * @param string $package
     * @param string $procedure
     * @param array|null $data
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateData(ExecutionContext $context, string $package, string $procedure, ?array $data): void;

    /**
     * @param ExecutionContext $context
     * @param string $package
     * @param string $procedure
     * @param array|null $meta
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateMeta(ExecutionContext $context, string $package, string $procedure, ?array $meta): void;
}

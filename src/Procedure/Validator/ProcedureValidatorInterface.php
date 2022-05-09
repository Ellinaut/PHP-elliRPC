<?php

namespace Ellinaut\ElliRPC\Procedure\Validator;

use Ellinaut\ElliRPC\Exception\ProcedureValidationException;

/**
 * @author Philipp Marien
 */
interface ProcedureValidatorInterface
{
    /**
     * @param string $package
     * @param string $procedure
     * @param array|null $data
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateData(string $package, string $procedure, ?array $data): void;

    /**
     * @param string $package
     * @param string $procedure
     * @param array|null $meta
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateMeta(string $package, string $procedure, ?array $meta): void;
}

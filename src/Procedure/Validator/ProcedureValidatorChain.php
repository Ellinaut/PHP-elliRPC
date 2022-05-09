<?php

namespace Ellinaut\ElliRPC\Procedure\Validator;

use Ellinaut\ElliRPC\Exception\ProcedureValidationException;

/**
 * @author Philipp Marien
 */
class ProcedureValidatorChain implements ProcedureValidatorInterface
{
    /**
     * @var ProcedureValidatorInterface[]
     */
    private array $validators = [];

    public function register(ProcedureValidatorInterface $validator): void
    {
        $this->validators[] = $validator;
    }

    /**
     * @param string $package
     * @param string $procedure
     * @param array|null $data
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateData(string $package, string $procedure, ?array $data): void
    {
        foreach ($this->validators as $validator) {
            $validator->validateData($package, $procedure, $data);
        }
    }

    /**
     * @param string $package
     * @param string $procedure
     * @param array|null $meta
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateMeta(string $package, string $procedure, ?array $meta): void
    {
        foreach ($this->validators as $validator) {
            $validator->validateMeta($package, $procedure, $meta);
        }
    }
}

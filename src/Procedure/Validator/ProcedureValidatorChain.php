<?php

namespace Ellinaut\ElliRPC\Procedure\Validator;

use Ellinaut\ElliRPC\Exception\ProcedureValidationException;
use Ellinaut\ElliRPC\Procedure\ExecutionContext;

/**
 * @author Philipp Marien
 */
class ProcedureValidatorChain implements ProcedureValidatorInterface
{
    /**
     * @var ProcedureValidatorInterface[]
     */
    private array $validators = [];

    public function register(ProcedureValidatorInterface $validator, ?ExecutionContext $context = null): void
    {
        if (!$context) {
            foreach (ExecutionContext::cases() as $validatorContext) {
                $this->validators[$validatorContext->name] = $validator;
            }
        } else {
            $this->validators[$context->name] = $validator;
        }
    }

    /**
     * @param ExecutionContext $context
     * @param string $package
     * @param string $procedure
     * @param array|null $data
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateData(ExecutionContext $context, string $package, string $procedure, ?array $data): void
    {
        if (!array_key_exists($context->name, $this->validators)) {
            return;
        }

        foreach ($this->validators[$context->name] as $validator) {
            $validator->validateData($context, $package, $procedure, $data);
        }
    }

    /**
     * @param ExecutionContext $context
     * @param string $package
     * @param string $procedure
     * @param array|null $meta
     * @return void
     * @throws ProcedureValidationException
     */
    public function validateMeta(ExecutionContext $context, string $package, string $procedure, ?array $meta): void
    {
        if (!array_key_exists($context->name, $this->validators)) {
            return;
        }

        foreach ($this->validators[$context->name] as $validator) {
            $validator->validateMeta($context, $package, $procedure, $meta);
        }
    }
}

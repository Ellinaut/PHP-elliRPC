<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\ErrorDefinitionInterface;
use Ellinaut\ElliRPC\Definition\PackageDefinitionInterface;
use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\SchemaDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class PackageDefinition extends AbstractArrayDefinition implements PackageDefinitionInterface
{
    private ?array $procedures = null;
    private ?array $schemas = null;
    private ?array $errors = null;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateString($definition, 'name');

        self::validateStringOrNull($definition, 'description');

        self::validateStringOrNull($definition, 'fallbackLanguage');

        self::validateDefinitionSet($definition, 'procedures', [ProcedureDefinition::class, 'validate']);

        self::validateDefinitionSet($definition, 'schemas', [SchemaDefinition::class, 'validate']);

        self::validateDefinitionSet($definition, 'errors', [ErrorDefinition::class, 'validate']);
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->definition['name'];
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->definition['description'];
    }

    /**
     * @return string|null
     */
    public function getFallbackLanguage(): ?string
    {
        return $this->definition['fallbackLanguage'];
    }

    /**
     * @return ProcedureDefinitionInterface[]
     * @throws DefinitionException
     */
    public function getProcedureDefinitions(): array
    {
        if (!$this->procedures) {
            $this->procedures = [];
            foreach ($this->definition['procedures'] as $procedure) {
                $this->procedures[] = new ProcedureDefinition($procedure);
            }
        }

        return $this->procedures;
    }

    /**
     * @return SchemaDefinitionInterface[]
     * @throws DefinitionException
     */
    public function getSchemaDefinitions(): array
    {
        if (!$this->schemas) {
            $this->schemas = [];
            foreach ($this->definition['schemas'] as $schema) {
                $this->schemas[] = new SchemaDefinition($schema);
            }
        }

        return $this->schemas;
    }

    /**
     * @return ErrorDefinitionInterface[]
     * @throws DefinitionException
     */
    public function getErrorDefinitions(): array
    {
        if (!$this->errors) {
            $this->errors = [];
            foreach ($this->definition['errors'] as $error) {
                $this->errors[] = new ErrorDefinition($error);
            }
        }

        return $this->errors;
    }

    /**
     * @throws DefinitionException
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'fallbackLanguage' => $this->getFallbackLanguage(),
            'procedures' => $this->getProcedureDefinitions(),
            'schemas' => $this->getSchemaDefinitions(),
            'errors' => $this->getErrorDefinitions(),
        ];
    }
}

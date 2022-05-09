<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
abstract class AbstractArrayDefinition
{
    /**
     * @throws DefinitionException
     */
    public function __construct(protected readonly array $definition)
    {
        static::validate($this->definition);
    }

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    abstract public static function validate(array $definition): void;

    /**
     * @param array $definition
     * @param string $key
     * @return void
     * @throws DefinitionException
     */
    protected static function validatePropertyExist(array $definition, string $key): void
    {
        if (!array_key_exists($key, $definition)) {
            throw new DefinitionException('Definition does not contain the property "' . $key . '"!');
        }
    }

    /**
     * @param array $definition
     * @param string $key
     * @return void
     * @throws DefinitionException
     */
    protected static function validateStringOrNull(array $definition, string $key): void
    {
        self::validatePropertyExist($definition, $key);

        if (!is_null($definition[$key]) && !is_string($definition[$key])) {
            throw new DefinitionException('Value for property "' . $key . '" have to be a string or null!');
        }
    }

    /**
     * @param array $definition
     * @param string $key
     * @return void
     * @throws DefinitionException
     */
    protected static function validateString(array $definition, string $key,): void
    {
        self::validatePropertyExist($definition, $key);

        if (!is_string($definition[$key]) || empty($definition[$key])) {
            throw new DefinitionException('Value for property "' . $key . '" have to be a non empty string!');
        }
    }

    /**
     * @param array $definition
     * @param string $key
     * @return void
     * @throws DefinitionException
     */
    protected static function validateBoolean(array $definition, string $key,): void
    {
        self::validatePropertyExist($definition, $key);

        if (!is_bool($definition[$key])) {
            throw new DefinitionException('Value for property "' . $key . '" have to be a boolean!');
        }
    }

    /**
     * @param array $definition
     * @param string $key
     * @param callable $definitionValidator
     * @return void
     * @throws DefinitionException
     */
    protected static function validateDefinition(
        array $definition,
        string $key,
        callable $definitionValidator
    ): void {
        self::validatePropertyExist($definition, $key);

        if (!is_array($definition[$key])) {
            throw new DefinitionException('Value of property "' . $key . '" have to be a definition object!');
        }

        $definitionValidator($definition[$key]);
    }

    /**
     * @param array $definition
     * @param string $key
     * @param callable $definitionValidator
     * @return void
     * @throws DefinitionException
     */
    protected static function validateDefinitionOrNull(
        array $definition,
        string $key,
        callable $definitionValidator
    ): void {
        self::validatePropertyExist($definition, $key);

        if (!is_null($definition[$key]) && !is_array($definition[$key])) {
            throw new DefinitionException('Value of property "' . $key . '" have to be a definition object or null!');
        }

        if ($definition[$key]) {
            $definitionValidator($definition[$key]);
        }
    }

    /**
     * @param array $definition
     * @param string $key
     * @param callable $definitionValidator
     * @return void
     * @throws DefinitionException
     */
    protected static function validateDefinitionSet(
        array $definition,
        string $key,
        callable $definitionValidator
    ): void {
        self::validatePropertyExist($definition, $key);

        if (!is_array($definition[$key]) || !array_is_list($definition[$key])) {
            throw new DefinitionException('Value of property "' . $key . '" have to be a set of zero or more definition objects!');
        }

        array_map($definitionValidator, $definition[$key]);
    }

    /**
     * @param array $definition
     * @param string $key
     * @param callable $definitionValidator
     * @return void
     * @throws DefinitionException
     */
    protected static function validateListOfStrings(
        array $definition,
        string $key
    ): void {
        self::validatePropertyExist($definition, $key);

        if (!is_array($definition[$key]) || !array_is_list($definition[$key])) {
            throw new DefinitionException('Value of property "' . $key . '" have to be an array of strings!');
        }

        foreach ($definition[$key] as $value) {
            if (!is_string($value)) {
                throw new DefinitionException('Each value of property "' . $key . '" have to be a string!');
            }
        }
    }
}

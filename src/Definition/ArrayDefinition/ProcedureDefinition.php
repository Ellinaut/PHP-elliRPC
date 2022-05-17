<?php

namespace Ellinaut\ElliRPC\Definition\ArrayDefinition;

use Ellinaut\ElliRPC\Definition\ProcedureDefinitionInterface;
use Ellinaut\ElliRPC\Definition\TransportDefinitionInterface;
use Ellinaut\ElliRPC\Exception\DefinitionException;

/**
 * @author Philipp Marien
 */
class ProcedureDefinition extends AbstractArrayDefinition implements ProcedureDefinitionInterface
{
    private ?TransportDefinitionInterface $request = null;
    private ?TransportDefinitionInterface $response = null;

    /**
     * @param array $definition
     * @return void
     * @throws DefinitionException
     */
    public static function validate(array $definition): void
    {
        self::validateString($definition, 'name');

        self::validateStringOrNull($definition, 'description');

        self::validateDefinition($definition, 'request', [TransportDefinition::class, 'validate']);

        self::validateDefinition($definition, 'response', [TransportDefinition::class, 'validate']);

        self::validateListOfStrings($definition, 'errors');

        self::validateString($definition, 'allowedUsage');
        if (
            $definition['allowedUsage'] && !in_array($definition['allowedUsage'], ['TRANSACTION', 'STANDALONE'], true)
        ) {
            throw new DefinitionException('Value for property "allowedUsage" have to be null, "TRANSACTION" or "STANDALONE"');
        }
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
     * @return TransportDefinitionInterface
     * @throws DefinitionException
     */
    public function getRequestDefinition(): TransportDefinitionInterface
    {
        if (!$this->request) {
            $this->request = new TransportDefinition($this->definition['request']);
        }

        return $this->request;
    }

    /**
     * @return TransportDefinitionInterface
     * @throws DefinitionException
     */
    public function getResponseDefinition(): TransportDefinitionInterface
    {
        if (!$this->response) {
            $this->response = new TransportDefinition($this->definition['response']);
        }

        return $this->response;
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->definition['errors'];
    }

    /**
     * @return string|null
     */
    public function getAllowedUsage(): ?string
    {
        return $this->definition['allowedUsage'];
    }


    /**
     * @throws DefinitionException
     */
    public function jsonSerialize(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'request' => $this->getRequestDefinition(),
            'response' => $this->getResponseDefinition(),
            'errors' => $this->getErrors(),
            'allowedUsage' => $this->getAllowedUsage()
        ];
    }
}

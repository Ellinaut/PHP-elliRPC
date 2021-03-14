<?php

namespace Ellinaut\ElliRPC\Definition;

/**
 * @author Philipp Marien
 */
class ProcedureDefinition implements ProcedureDefinitionInterface
{
    /**
     * @var string
     */
    private string $name;

    /**
     * @var string|null
     */
    private ?string $description;

    /**
     * @var string[]
     */
    private array $methods;

    /**
     * @var string[]
     */
    private array $contentTypes;

    /**
     * @var RequestDefinitionInterface
     */
    private RequestDefinitionInterface $requestDefinition;

    /**
     * @var DataDefinitionInterface|null
     */
    private ?DataDefinitionInterface $responseDataDefinition;

    /**
     * @param string $name
     * @param string|null $description
     * @param string[] $methods
     * @param string[] $contentTypes
     * @param RequestDefinitionInterface $requestDefinition
     * @param DataDefinitionInterface|null $responseDataDefinition
     */
    public function __construct(
        string $name,
        ?string $description,
        array $methods,
        array $contentTypes,
        RequestDefinitionInterface $requestDefinition,
        ?DataDefinitionInterface $responseDataDefinition
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->methods = $methods;
        $this->contentTypes = $contentTypes;
        $this->requestDefinition = $requestDefinition;
        $this->responseDataDefinition = $responseDataDefinition;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @return string[]
     */
    public function getContentTypes(): array
    {
        return $this->contentTypes;
    }

    /**
     * @return RequestDefinitionInterface
     */
    public function getRequestDefinition(): RequestDefinitionInterface
    {
        return $this->requestDefinition;
    }

    /**
     * @return DataDefinitionInterface|null
     */
    public function getResponseDataDefinition(): ?DataDefinitionInterface
    {
        return $this->responseDataDefinition;
    }
}

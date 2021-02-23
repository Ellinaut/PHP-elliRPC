<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
interface ProcedureInterface extends ProcedureIdentificationInterface
{
    /**
     * @return array
     */
    public function getRequestData(): array;

    /**
     * @return array|null
     */
    public function getPagination(): ?array;

    /**
     * @return string|null
     */
    public function getSorting(): ?string;
}

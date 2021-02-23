<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
interface ProcedureResultInterface extends ProcedureIdentificationInterface
{
    public function getResponseData(): ?array;
}

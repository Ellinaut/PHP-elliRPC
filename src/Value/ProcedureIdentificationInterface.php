<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
interface ProcedureIdentificationInterface
{

    /**
     * @return string
     */
    public function getProcedureId(): string;

    /**
     * @return string
     */
    public function getPackageName(): string;

    /**
     * @return string
     */
    public function getProcedureName(): string;
}

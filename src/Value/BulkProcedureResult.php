<?php

namespace Ellinaut\ElliRPC\Value;

/**
 * @author Philipp Marien
 */
class BulkProcedureResult extends ProcedureResult
{
    public function __construct(
        protected readonly RemoteProcedure $procedure,
        protected readonly ProcedureResult $result
    ) {
        parent::__construct(
            $this->result->isSuccess(),
            $this->result->getData(),
            $this->result->getMeta(),
            $this->result->getErrors()
        );
    }

    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array_merge(
            [
                'package' => $this->procedure->getPackageName(),
                'procedure' => $this->procedure->getProcedureName(),
            ],
            parent::jsonSerialize()
        );
    }
}

<?php

namespace Ellinaut\ElliRPC\Client\Processor;

use Ellinaut\ElliRPC\Client\Connector\AbstractRemoteConnector;
use Ellinaut\ElliRPC\Value\ProcedureInterface;
use Ellinaut\ElliRPC\Value\ProcedureResultInterface;
use Throwable;

/**
 * @author Philipp Marien
 */
class ProcedureRemoteProcessor extends AbstractRemoteConnector implements ProcedureProcessorInterface
{
    /**
     * @param ProcedureInterface $procedure
     * @param string $method
     * @return ProcedureResultInterface
     * @throws Throwable
     */
    public function process(ProcedureInterface $procedure, string $method): ProcedureResultInterface
    {
        $request = $this->buildJsonRequest(
            $method,
            '/elliRPC/' . $procedure->getPackageName() . '/' . $procedure->getProcedureName() . '.json',
            $this->buildProcedureQuery($procedure, $method),
            ($procedure->getRequestData() !== null && !$this->shouldSendDataInQuery($method)) ? $procedure->getRequestData() : null
        );

        $this->executeJsonRequest($request);
    }

    /**
     * @param ProcedureInterface $procedure
     * @param string $method
     * @return array|null
     */
    protected function buildProcedureQuery(ProcedureInterface $procedure, string $method): ?array
    {
        $query = [];

        if ($procedure->getPagination() !== null) {
            $query['pagination'] = $procedure->getPagination();
        }

        if ($procedure->getSorting() !== null) {
            $query['sort'] = $procedure->getPagination();
        }

        if ($procedure->getRequestData() !== null && $this->shouldSendDataInQuery($method)) {
            $query['data'] = $procedure->getRequestData();
        }

        return empty($query) ? null : $query;
    }

    /**
     * @param string $method
     * @return bool
     */
    protected function shouldSendDataInQuery(string $method): bool
    {
        return in_array(strtoupper($method), ['GET', 'DELETE'], true);
    }
}

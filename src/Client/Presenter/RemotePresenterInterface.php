<?php

namespace Ellinaut\ElliRPC\Client\Presenter;

/**
 * @author Philipp Marien
 */
interface RemotePresenterInterface
{
    public function createView(array $filter, array $pagination, string $sort): array;
}

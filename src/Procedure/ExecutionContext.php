<?php

namespace Ellinaut\ElliRPC\Procedure;

/**
 * @author Philipp Marien
 */
enum ExecutionContext: string
{
    case STANDALONE = 'STANDALONE';

    case TRANSACTION = 'TRANSACTION';
}

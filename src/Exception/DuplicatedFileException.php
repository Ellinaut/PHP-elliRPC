<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class DuplicatedFileException extends InvalidRequestException
{
    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct(
            'File "' . $fileName . '" does already exist, please choose an other name.',
            20210322150153
        );
    }
}

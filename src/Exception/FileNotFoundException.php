<?php

namespace Ellinaut\ElliRPC\Exception;

/**
 * @author Philipp Marien
 */
class FileNotFoundException extends NotFoundException
{
    /**
     * @param string $fileName
     */
    public function __construct(string $fileName)
    {
        parent::__construct('The file "' . $fileName . '" could not be found.', 20210322141210);
    }
}

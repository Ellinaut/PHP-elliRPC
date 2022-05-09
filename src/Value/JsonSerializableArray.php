<?php

namespace Ellinaut\ElliRPC\Value;

use ArrayObject;
use JsonSerializable;

/**
 * @author Philipp Marien
 */
class JsonSerializableArray extends ArrayObject implements JsonSerializable
{
    /**
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }
}

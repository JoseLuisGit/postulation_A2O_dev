<?php

namespace App\StringValue;

use App\StringValue\SubStringValue;

class StringValue
{


    public $subStringsValue;

    public function __construct()
    {
        $this->subStringsValue = array();
    }

    public function addSubStringValue(SubStringValue $subStringsValue)
    {
        $this->subStringsValue[] = $subStringsValue;
    }

    public function getValueMax()
    {
        usort($this->subStringsValue, function ($subStringsValue_a, $subStringsValue_b) {
            return $subStringsValue_a->value > $subStringsValue_b->value;
        });

        return $this->subStringsValue[0]->getValue();
    }
}

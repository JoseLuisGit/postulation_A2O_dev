<?php

namespace App\StringValue;

class SubStringValue
{
    public $subString;
    public $value;


    public function __construct($subString, $value)
    {
        $this->subString = $subString;
        $this->value = strlen($subString) * $value;
    }

    public function getValue()
    {
        return $this->value;
    }
}

<?php

namespace App\StringValue;

use App\StringValue\SubStringValue;

class StringValue
{
    protected array $subStringsValues;

    public function __construct()
    {
        $this->subStringsValues = [];
    }

    public function generateSubString(string $text){
        for ($i = 0; $i < strlen($text); $i++) {
            for ($j = $i + 1; $j <= strlen($text); $j++) {
                $counter = 0;
                $subText = substr($text, $i, $j - $i);
                if (strpos($text, $subText) === $i) {
                    for ($k = $i; $k < strlen($text); $k++) {
                        $auxTemp = substr($text, $k);
                        if (strpos($auxTemp, $subText) === false) {
                            break;
                        } else if (strpos($auxTemp, $subText) === 0) {
                            $counter++;
                        }
                    }
                    $subString = new SubStringValue($subText, $counter);
                    $this->addSubStringValue($subString);
                }
            }
        }
    }

    private function addSubStringValue(SubStringValue $subStringsValue)
    {
        $this->subStringsValues[] = $subStringsValue;
    }

    public function getValueMax()
    {
        $max = 0;
        foreach($this->subStringsValues as $subStringsValue){
            $value = $subStringsValue->getValue();
            if($max < $value){
                $max = $value;
            }
        }
        return $max;
    }

    public function getSubStringValues(){
        return $this->subStringsValues;
    }
}

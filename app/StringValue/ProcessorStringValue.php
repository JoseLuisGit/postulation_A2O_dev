<?php


namespace App\StringValue;

use App\StringValue\StringValue;
use App\StringValue\SubStringValue;
use App\Exceptions\Error;

class ProcessorStringValue
{

    public StringValue $stringValue;
    public Error $error;

    public function __construct()
    {
        $this->stringValue = new StringValue();
        $this->error = new Error();
    }



    public function processorStringValue($string)
    {
        $string = trim($string);
        if (!preg_match("/^[a-z]+$/", $string)) {
            $this->error->setMessage("Invalid Data");
            return false;
        }
        for ($i = 0; $i < strlen($string); $i++) {
            for ($j = $i + 1; $j <= strlen($string); $j++) {
                $counter = 0;
                $subString = substr($string, $i, $j - $i);
                if (strpos($string, $subString) === $i) {
                    for ($k = $i; $k < strlen($string); $k++) {
                        $temporalString = substr($string, $k);
                        if (strpos($temporalString, $subString) === false) {
                            break;
                        } else if (strpos($temporalString, $subString) === 0) {
                            $counter++;
                        }
                    }
                    $this->stringValue->addSubStringValue(new SubStringValue($subString, strlen($subString) * $counter));
                }
            }
        }
        return true;
    }

    public function getMaxStringValue()
    {

        return $this->stringValue->getValueMax();
    }
}

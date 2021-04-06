<?php

namespace App\Exceptions;

class Error
{
    public $message;


    public function setMessage($message)
    {
        $this->message = $message;
    }
    public function getMessage()
    {
        return $this->message;
    }
}

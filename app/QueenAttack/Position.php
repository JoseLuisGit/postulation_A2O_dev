<?php

namespace App\QueenAttack;

class Position
{
    public $row;
    public $column;

    public function __construct($row, $column)
    {
        $this->row = $row;
        $this->column =  $column;
    }

    public function __toString()
    {
        return "\n" .  $this->row . " , " . $this->column;
    }
}

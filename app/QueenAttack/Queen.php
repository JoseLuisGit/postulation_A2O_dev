<?php

namespace App\QueenAttack;

use App\Helpers\PositionHelper;
use App\QueenAttack\Position;

class Queen
{
    public Position $position;

    public function __construct($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function getRow(){
        return $this->getPosition()->row;
    }

    public function getColumn(){
        return $this->getPosition()->column;
    }

}

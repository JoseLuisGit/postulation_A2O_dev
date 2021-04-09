<?php

namespace App\QueenAttack;

use App\QueenAttack\Point;

class Queen
{
    public Point $position;


    public function __construct($position)
    {
        $this->position = $position;
    }

    public function getPosition()
    {

        return $this->position;
    }



    public function addPointFreeOfPosition(Point $point)
    {
        $this->pointFreeOfPosition[] =  $point;
    }

    public function getPointFreeOfPosition()
    {
        return $this->pointFreeOfPosition;
    }
}

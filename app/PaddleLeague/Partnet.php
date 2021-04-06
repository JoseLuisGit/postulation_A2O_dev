<?php

namespace App\PaddleLeague;

class  Partnet
{
    public $name;
    public $points;

    public function __construct($name)
    {
        $this->setName($name);
        $this->setPoints(0);
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function scorePoints($score)
    {
        $this->setPoints($score + $this->getPoints());
    }
}

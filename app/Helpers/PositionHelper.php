<?php
namespace App\Helpers;

use App\QueenAttack\Position;

class PositionHelper{

    static function convertRelativeRow($dimension, $row){
        return $dimension - $row;
    }

    static function convertRelativeColumn($column)
    {
        return $column - 1;
    }

    static function getPositionRelative($dimension, $row, $column){
        return new Position(self::convertRelativeRow($dimension, $row), 
                            self::convertRelativeColumn($column));
    }
}

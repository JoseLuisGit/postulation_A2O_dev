<?php

namespace App\QueenAttack;

use App\QueenAttack\Point;
use App\QueenAttack\Queen;

class Board
{
    public $board;
    public $dimension;
    public Queen $queen;


    public function __construct($dimension)
    {
        $this->dimension = $dimension;
        $this->initBoard();
    }



    private function initBoard()
    {
        $this->board = array_fill(0, $this->dimension, array_fill(0, $this->dimension, 0));
    }

    public function setQueen(Queen $queen)
    {
        $this->queen = $queen;
    }

    public function fillObstacles($obstacle)
    {
        $positionQueen = $this->queen->getPosition();

        if (!$this->pointInRangeDimensionBoard($obstacle->row, $obstacle->column) && $positionQueen->row === $obstacle->row && $positionQueen->column === $obstacle->column) {
            return false;
        }
        $this->board[$obstacle->row][$obstacle->column] = "X";
        return true;
    }

    public function pointInRangeDimensionBoard($row, $column)
    {
        return $this->isInt($row)  && $this->isInt($column) && (($this->dimension - 1) <= $row && ($row >= 0)) || (($this->dimension - 1) <= $column && $column >= 0);
    }

    private function isInt($number)
    {
        return preg_match('/^-?[0-9]+$/', $number);
    }

    public function printBoard()
    {
        for ($i = 0; $i < $this->dimension; $i++) {
            for ($j = 0; $j < $this->dimension; $j++) {
                echo $this->board[$i][$j] . " ";
            }
            echo "\n";
        }
    }



    public function countSpacesFreeQueen()
    {
        $c = 0;
        $positionQueen = $this->queen->getPosition();
        $this->countHorizontalUp($positionQueen, $c);
        $this->countHorizontalDown($positionQueen, $c);
        $this->countVerticalRight($positionQueen, $c);
        $this->countVerticalLeft($positionQueen, $c);
        $this->countDiagonalXUp($positionQueen, $c);
        $this->countDiagonalXDown($positionQueen, $c);
        $this->countDiagonalYDown($positionQueen, $c);
        $this->countDiagonalYUp($positionQueen, $c);
        return $c;
    }

    public function getPointFreeOfPositionQueen()
    {
        return $this->queen->getPointFreeOfPosition();
    }


    private function countHorizontalUp($position, &$c)
    {
        // ^
        // |  row(-)
        $i = $position->row - 1;
        while ($i >= 0) {
            if ($this->board[$i][$position->column] !== 'X') {
                $c++;
            } else {
                break;
            }

            $i--;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i + 1, $position->column));
        return $c;
    }

    private function countHorizontalDown($position, &$c)
    {

        // |
        // v row(+)
        $i = $position->row + 1;
        while ($i < $this->dimension) {
            if ($this->board[$i][$position->column] !== 'X') {
                $c++;
            } else {

                break;
            }
            $i++;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i - 1, $position->column));
        return $c;
    }

    private function countVerticalLeft($position, &$c)
    {
        // <---- 
        $i = $position->column - 1;
        while ($i >= 0) {
            if ($this->board[$position->row][$i] !== 'X') {
                $c++;
            } else {

                break;
            }
            $i--;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($position->row, $i + 1));
        return $c;
    }

    private function countVerticalRight($position, &$c)
    {
        // ----> 
        $i = $position->column + 1;
        while ($i < $this->dimension) {
            if ($this->board[$position->row][$i] !== 'X') {
                $c++;
            } else {

                break;
            }
            $i++;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($position->row, $i - 1));
        return $c;
    }


    private function countDiagonalXUp($position, &$c)
    {
        $i = $position->row - 1;
        $j = $position->column - 1;
        while ($i >= 0 && $j >= 0) {
            if ($this->board[$i][$j] !== 'X') {
                $c++;
            } else {

                break;
            }

            $i--;
            $j--;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i + 1, $j + 1));
        return $c;
    }
    private function countDiagonalXDown($position, &$c)
    {
        $i = $position->row + 1;
        $j = $position->column + 1;
        while ($i < $this->dimension && $j < $this->dimension) {
            if ($this->board[$i][$j] !== 'X') {
                $c++;
            } else {

                break;
            }

            $i++;
            $j++;
        }

        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i - 1, $j - 1));
        return $c;
    }

    private function countDiagonalYDown($position, &$c)
    {

        $i = $position->row + 1;
        $j = $position->column - 1;
        while ($i < $this->dimension && $j >= 0) {
            if ($this->board[$i][$j] !== 'X') {
                $c++;
            } else {

                break;
            }
            $i++;
            $j--;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i - 1, $j + 1));
        return $c;
    }

    private function countDiagonalYUp($position, &$c)
    {
        $i = $position->row - 1;
        $j = $position->column + 1;
        while ($i >= 0 && $j < $this->dimension) {
            if ($this->board[$i][$j] !== 'X') {
                $c++;
            } else {

                break;
            }
            $i--;
            $j++;
        }
        //switch type piece
        $this->queen->addPointFreeOfPosition(new Point($i + 1, $j - 1));
        return $c;
    }
}

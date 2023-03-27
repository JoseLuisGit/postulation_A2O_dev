<?php

namespace App\QueenAttack;

use App\QueenAttack\Queen;
use Illuminate\Support\MessageBag;

class Board
{

    protected const TOP_RIGHT = 'top_right';
    protected const TOP_LEFT = 'top_left';
    protected const DOWN_RIGHT = 'down_right';
    protected const DOWN_LEFT = 'down_left';

    public $board;
    public $dimension;
    public $countSpacesQueen;
    public MessageBag $errors;


    public function __construct($dimension)
    {
        $this->errors = new MessageBag();
        $this->dimension = $dimension;
        $this->countSpacesQueen = 0;
    }


    public function queenAttack(Queen $queen, array $obstacles){
        $this->initBoard();
        $this->setQueen($queen);

        foreach($obstacles as $obstacle){
           if(!$this->fillObstacles($queen, $obstacle)){
                $this->errors->add('error', 'The obstacle collides with the position of the queen.');
           }
        }

        if(!empty($this->errors)){
            $directionFinalized = [];
            $directions = [ self::TOP_LEFT, self::TOP_RIGHT, self::DOWN_RIGHT, self::DOWN_LEFT];

            $i = 1;
            $posQueen = $queen->getPosition();
            while(true){
                foreach($directions as $direction){
                    if(!in_array($direction, $directionFinalized)){
                        switch ($direction) {
                            case self::TOP_LEFT:
                                $row = $posQueen->row - $i;
                                $col = $posQueen->column - $i;
                                $this->markPosition($row, $col, $direction, $directionFinalized);
                                break;
                            case self::TOP_RIGHT:
                                $row = $posQueen->row - $i;
                                $col = $posQueen->column + $i;
                                $this->markPosition($row, $col, $direction, $directionFinalized);
                                break;
                            case self::DOWN_RIGHT:
                                $row = $posQueen->row + $i;
                                $col = $posQueen->column - $i;
                                $this->markPosition($row, $col, $direction, $directionFinalized);
                                break;
                            case self::DOWN_LEFT:
                                $row = $posQueen->row + $i;
                                $col = $posQueen->column + $i;
                                $this->markPosition($row, $col, $direction, $directionFinalized);
                                break;
                            default:
                                break;
                        }
                    }
                }
                $i++;

                if(count($directionFinalized) == count($directions)){
                    break;
                }
            }
        }
    }

    public function getSpacesQueen(){
        return $this->countSpacesQueen;
    }

    private function markPosition($row, $col, $direction, &$directions){
        if($this->inRangeAndNotObstacule($row, $col)){
            $this->countSpacesQueen++;
            $this->board[$row][$col] = 'O';
        }else{
            $directions[] = $direction;
        }
    }

    private function inRangeAndNotObstacule($row, $col){
        return $row <= ( $this->dimension - 1 ) && $row >= 0 &&
               $col <= ( $this->dimension - 1 ) && $col >= 0 && $this->board[$row][$col] !== 'X';
    }

    private function initBoard()
    {
        $this->board = array_fill(0, $this->dimension, array_fill(0, $this->dimension, ''));
    }

    public function setQueen(Queen $queen)
    {
        $this->board[$queen->getRow()][$queen->getColumn()] = "Q";
    }

    public function fillObstacles(Queen $queen, $obstacle)
    {
        if($obstacle->row == $queen->getRow() && $obstacle->column == $queen->getColumn()){
            return false;
        }
        $this->board[$obstacle->row][$obstacle->column] = "X";
        return true;
    }

    public function printBoard()
    {
        $str = '';
        for ($i = 0; $i < $this->dimension; $i++) {
            for ($j = 0; $j < $this->dimension; $j++) {
                $str = $str . $this->board[$i][$j] . " ";
            }
            $str = $str . "\n";
        }
        return $str;
    }

    public function getBoard(){
        return $this->board;
    }

}

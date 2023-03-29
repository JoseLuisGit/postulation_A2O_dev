<?php

namespace App\QueenAttack;

use App\QueenAttack\Queen;
use Illuminate\Support\MessageBag;

class Board
{

    protected const TOP = 'top';
    protected const LEFT = 'left';
    protected const DOWN = 'down';
    protected const RIGHT = 'right';
    protected const TOP_DIAGONAL_RIGHT = 'top_diagonal_right';
    protected const TOP_DIAGONAL_LEFT = 'top_diagonal_left';
    protected const DOWN_DIAGONAL_RIGHT = 'down_diagonal_right';
    protected const DOWN_DIAGONAL_LEFT = 'down_diagonal_left';

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


    public function queenAttack(Queen $queen, array $obstacles)
    {
        $this->initBoard();
        $this->setQueen($queen);

        foreach ($obstacles as $obstacle) {
            if (!$this->fillObstacles($queen, $obstacle)) {
                $this->errors->add('error', 'The obstacle collides with the position of the queen.');
            }
        }

        if (!empty($this->errors)) {
            $directions = [
                self::TOP_DIAGONAL_LEFT, self::TOP, self::TOP_DIAGONAL_RIGHT,
                self::RIGHT, self::DOWN_DIAGONAL_RIGHT, self::DOWN, self::DOWN_DIAGONAL_LEFT,
                self::LEFT
            ];
            $this->markSpacePiece($queen->getPosition(), $directions);
        }
    }
    

    public function markSpacePiece(Position $piecePosition, array $directions)
    {
        $directionFinalized = [];

        $i = 1;
        while (true) {
            foreach ($directions as $direction) {
                if (!in_array($direction, $directionFinalized)) {
                    switch ($direction) {
                        case self::TOP_DIAGONAL_LEFT:
                            $row = $piecePosition->row - $i;
                            $col = $piecePosition->column - $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::TOP:
                            $row = $piecePosition->row - $i;
                            $col = $piecePosition->column;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::TOP_DIAGONAL_RIGHT:
                            $row = $piecePosition->row - $i;
                            $col = $piecePosition->column + $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::RIGHT:
                            $row = $piecePosition->row;
                            $col = $piecePosition->column + $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::DOWN_DIAGONAL_RIGHT:
                            $row = $piecePosition->row + $i;
                            $col = $piecePosition->column + $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::DOWN:
                            $row = $piecePosition->row + $i;
                            $col = $piecePosition->column;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::DOWN_DIAGONAL_LEFT:
                            $row = $piecePosition->row + $i;
                            $col = $piecePosition->column - $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        case self::LEFT:
                            $row = $piecePosition->row;
                            $col = $piecePosition->column - $i;
                            $this->markPosition($row, $col, $direction, $directionFinalized);
                            break;
                        default:
                            break;
                    }
                }
            }
            $i++;

            if (count($directionFinalized) == count($directions)) {
                break;
            }
        }
    }

    public function getSpacesQueen()
    {
        return $this->countSpacesQueen;
    }

    private function markPosition($row, $col, $direction, &$directions)
    {
        if ($this->inRangeAndNotObstacule($row, $col)) {
            $this->countSpacesQueen++;
            $this->board[$row][$col] = 'O';
        } else {
            $directions[] = $direction;
        }
    }

    private function inRangeAndNotObstacule($row, $col)
    {
        return $row <= ($this->dimension - 1) && $row >= 0 &&
            $col <= ($this->dimension - 1) && $col >= 0 && $this->board[$row][$col] !== 'X';
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
        if ($obstacle->row == $queen->getRow() && $obstacle->column == $queen->getColumn()) {
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

    public function getBoard()
    {
        return $this->board;
    }
}

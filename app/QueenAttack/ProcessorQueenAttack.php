<?php

namespace App\QueenAttack;

use App\QueenAttack\Board;
use App\QueenAttack\Queen;

class ProcessorQueenAtack
{

    public Board $board;


    public function processingWord($word)
    {

        $word = trim($word);

        $arrayDataString = explode("\n", $word);

        // $this->board = new Board($dimension);
        // $this->board->setQueen(new Queen($positionQueen));
        // $this->board->fillObstacles($obstacles);
        // $this->board->printBoard();
    }

    public function getSpacesQueenAttack()
    {
        return  $this->board->countSpacesFreeQueen();
    }
}

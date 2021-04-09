<?php

namespace App\QueenAttack;

use App\Exceptions\Error;
use App\QueenAttack\Board;
use Exception;

class ProcessorQueenAttack
{

    public Board $board;
    public Error $error;



    public function __construct()
    {
        $this->error =  new Error();
    }

    public function processingWord($word)
    {
        try {

            $word = trim($word);

            $arrayDataString = explode("\n", $word);
            $arrayDataString = array_diff($arrayDataString, [""]);
            $arrayDataString = array_values($arrayDataString);


            $lenghtArrayDataString = count($arrayDataString);
            if ($lenghtArrayDataString < 2) {
                $this->error->setMessage("Invalid Data");
                return false;
            }
            $iterationArrayDataString = 0;
            $numberOfObstacles = 0;

            while ($iterationArrayDataString < $lenghtArrayDataString && ($iterationArrayDataString - 2) < $numberOfObstacles) {
                if ($iterationArrayDataString == 0) {
                    $firstData = preg_split("/[\s]/", $arrayDataString[0]);
                    $secondData = preg_split("/[\s]/", $arrayDataString[1]);
                    $firstData = array_diff($firstData, [""]);
                    $secondData = array_diff($secondData, [""]);
                    $firstData = array_values($firstData);
                    $secondData = array_values($secondData);




                    if (count($firstData) == 2 && count($secondData) == 2) {

                        $dimension = $firstData[0];
                        $numberOfObstacles = $firstData[1];
                        $rowQueen = $secondData[0];
                        $columnQueen = $secondData[1];


                        if ($this->isNumberInRange($dimension) && $dimension > 0 && $this->isNumberInRange($numberOfObstacles) && $numberOfObstacles >= 0) {
                            if ($numberOfObstacles > $lenghtArrayDataString - 2) {
                                $this->error->setMessage("number of missing obstacles");
                                return false;
                            }
                            $this->board = new Board($dimension);
                            if ($this->board->pointInRangeDimensionBoardRelative($rowQueen, $columnQueen)) {
                                $this->board->setQueen(new Queen(new Point($this->convertRelativeRow($rowQueen, $dimension), $this->convertRelativeColumn($columnQueen))));
                            } else {
                                $this->error->setMessage("position of the queen invalid ");
                                return false;
                            }
                        } else {
                            $this->error->setMessage("number of obstacles or wrong dimension ");
                            return false;
                        }
                    } else {
                        $this->error->setMessage("Invalid Data");
                        return false;
                    }

                    $iterationArrayDataString++;
                } else {
                    $dataObstacle = preg_split("/[\s]/", $arrayDataString[$iterationArrayDataString]);
                    $dataObstacle = array_diff($dataObstacle, [""]);
                    if (count($dataObstacle) == 2) {
                        $relativeRow = $this->convertRelativeRow($dataObstacle[0], $this->board->dimension);
                        $relativeColumn = $this->convertRelativeColumn($dataObstacle[1]);

                        if (!$this->board->fillObstacles(new Point($relativeRow, $relativeColumn))) {
                            $this->error->setMessage("Invalid Obstacle");
                            return false;
                        }
                    } else {
                        $this->error->setMessage("invalid obstacle");
                        return false;
                    }
                }

                $iterationArrayDataString++;
            }

            // $this->board = new Board($dimension);
            // $this->board->setQueen(new Queen($positionQueen));
            // $this->board->fillObstacles($obstacles);
            // echo $this->board->printBoard();

            return true;
        } catch (Exception $e) {
            $this->error->setMessage("invalid string");
            return false;
        }
    }


    private function convertRelativeRow($rowOld, $dimension)
    {
        return $dimension - $rowOld;
    }

    private function convertRelativeColumn($columnOld)
    {
        return $columnOld - 1;
    }

    private function isNumberInRange($data)
    {
        return preg_match("/^[[:digit:]]+$/", $data) && $data <= 10e+5;
    }

    public function getSpacesQueenAttack()
    {
        return  $this->board->countSpacesFreeQueen();
    }

    public function getBoard()
    {
        return $this->board->board;
    }
}

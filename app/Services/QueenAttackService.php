<?php
namespace App\Services;

use App\Helpers\PositionHelper;
use App\QueenAttack\Board;
use App\QueenAttack\Point;
use App\QueenAttack\Queen;
use Exception;
use Illuminate\Support\Facades\Log;

class QueenAttackService extends BaseService
{
    public function processText($text)
    {
        try {

            $inputs = explode("\n", $text);

            if(count($inputs) < 2){
                $this->errors->add('error', 'insufficient data');
            }

            if(!$this->hasErrors()){
                $firstInput = explode(' ', rtrim($inputs[0]));
                $dimension = intval($firstInput[0]);
                $numObstacles = intval($firstInput[1]);

                $secondInput = explode(' ', $inputs[1]);
                $rowPos = intval($secondInput[0]);
                $colPos = intval($secondInput[1]);

                $obstacles = [];
                for($i = 0; $i < $numObstacles; $i++){
                    $obstacle = explode(' ', rtrim($inputs[$i + 2]));
                    $obstaclePos = PositionHelper::getPositionRelative($dimension, $obstacle[0], $obstacle[1]);
                    $obstacles[] = $obstaclePos;
                }

                $board = new Board($dimension);
                $queen = new Queen(PositionHelper::getPositionRelative($dimension, $rowPos, $colPos));


                $board->queenAttack($queen, $obstacles);

                if(count($board->errors) > 0){
                    $this->errors->merge($board->errors);
                }

                return $board;
            }

        }
        catch(Exception $e){
            $this->errors->add('error', 'Invalid data');
        }
    }

}
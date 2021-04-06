<?php

namespace App\PaddleLeague;

use App\Constants\ConstantsPaddleLeague;
use App\PaddleLeague\PaddleLeague;
use App\PaddleLeague\Category;
use App\Exceptions\Error;
use Exception;

class ProcessorPaddleLeague
{

    public PaddleLeague $paddleLeague;
    public Error $error;
    public function __construct()
    {

        $this->paddleLeague = new PaddleLeague();
    }

    public function processText($contentText)
    {

        try {
            $contentText = trim($contentText);
            $separatingArrayCategoryString = explode('FIN', $contentText);
            $separatingArrayCategoryString = array_diff($separatingArrayCategoryString, [""]);
            $separatingArrayCategoryString =  array_values($separatingArrayCategoryString);

            $shortCut = $this->paddleLeague;
            foreach ($separatingArrayCategoryString as $keycategory => $categoryString) {

                $separatingArrayPartnetWithResultString  = preg_split("/[\s]/", trim($categoryString));
                $separatingArrayPartnetWithResultString = array_diff($separatingArrayPartnetWithResultString, [""]);
                $separatingArrayPartnetWithResultString = array_values($separatingArrayPartnetWithResultString);
                $iterationPartnetResult = 0;

                $lenghtArrayPartnetResult = count($separatingArrayPartnetWithResultString);

                $category = new Category('');


                while ($lenghtArrayPartnetResult > $iterationPartnetResult) {

                    $data = $separatingArrayPartnetWithResultString[$iterationPartnetResult];


                    if (strlen($data) > 16) {
                        $this->error->setMessage("Error: Lenght Max String 16 ");
                        return false;
                    } {
                        if ($iterationPartnetResult == 0) {
                            $shortCut->addcategory(new Category($data));
                            $category = $this->paddleLeague->category[$keycategory];
                        } else {
                            $local =  $separatingArrayPartnetWithResultString[$iterationPartnetResult];
                            $scoreLocal = $separatingArrayPartnetWithResultString[$iterationPartnetResult + 1];
                            $visitor = $separatingArrayPartnetWithResultString[$iterationPartnetResult + 2];
                            $scoreVisitor = $separatingArrayPartnetWithResultString[$iterationPartnetResult + 3];
                            $category->sumEncounters();
                            if (!$category->existParticipant($local)) {
                                $category->addParticipant(new Partnet($local));
                            }

                            if (!$category->existParticipant($visitor)) {
                                $category->addParticipant(new Partnet($visitor));
                            }

                            if ($scoreLocal > $scoreVisitor) {
                                $category->participants[$category->positionParticipant($local)]->scorePoints(ConstantsPaddleLeague::VICTORY);
                                $category->participants[$category->positionParticipant($visitor)]->scorePoints(ConstantsPaddleLeague::DEFEAT);
                            } elseif ($scoreLocal < $scoreVisitor) {
                                $category->participants[$category->positionParticipant($local)]->scorePoints(ConstantsPaddleLeague::DEFEAT);
                                $category->participants[$category->positionParticipant($visitor)]->scorePoints(ConstantsPaddleLeague::VICTORY);
                            } else {

                                return false;
                            }

                            $iterationPartnetResult += 3;
                        }


                        $iterationPartnetResult++;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            $this->error->setMessage("Error: String Invalid");
            return false;
        }
    }

    public function responsePaddleLeague()
    {
        $response = '';
        $category = $this->paddleLeague->category;
        foreach ($category as $datacategory) {
            $response = $response + $datacategory->getWinner() . ' ' . $datacategory->getGamesNotPlayed() . "\n";
        }

        return $response;
    }
}

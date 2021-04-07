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
        $this->error = new Error();
        $this->paddleLeague = new PaddleLeague();
    }

    public function processText($word)
    {

        try {
            $word = trim($word);
            $separatingArrayCategoryString = explode('FIN', $word);
            $separatingArrayCategoryString = array_diff($separatingArrayCategoryString, [""]);
            $separatingArrayCategoryString =  array_values($separatingArrayCategoryString);


            unset($separatingArrayCategoryString[count($separatingArrayCategoryString) - 1]);

            $shortCut = $this->paddleLeague;

            $category = new Category('');

            foreach ($separatingArrayCategoryString as $keycategory => $categoryString) {
                if (trim($categoryString) != "") {

                    $separatingArrayPartnetString  = preg_split("[\n]", trim($categoryString));
                    $separatingArrayPartnetString = array_diff($separatingArrayPartnetString, [""]);
                    $separatingArrayPartnetString = array_values($separatingArrayPartnetString);
                    $iterationPartnetResult = 0;

                    $lenghtArrayPartnetResult = count($separatingArrayPartnetString);



                    while ($lenghtArrayPartnetResult > $iterationPartnetResult) {

                        $data = $separatingArrayPartnetString[$iterationPartnetResult];


                        if ($iterationPartnetResult == 0) {
                            $shortCut->addcategory(new Category($data));
                            $category = $this->paddleLeague->category[$keycategory];
                        } else {
                            $datasEncounter = preg_split("/[\s]/", $data);
                            $datasEncounter = array_diff($datasEncounter, [""]);
                            $datasEncounter = array_values($datasEncounter);
                            if (count($datasEncounter) == 4) {

                                $local =  $datasEncounter[0];
                                $scoreLocal = $datasEncounter[1];
                                $visitor = $datasEncounter[2];
                                $scoreVisitor = $datasEncounter[3];

                                if (!$category->existParticipant($local)) {
                                    $category->addParticipant(new Partnet($local));
                                }

                                if (!$category->existParticipant($visitor)) {
                                    $category->addParticipant(new Partnet($visitor));
                                }

                                $localPartnet =  $category->participants[$category->positionParticipant($local)];
                                $visitorPartnet =  $category->participants[$category->positionParticipant($visitor)];
                                if (!$category->addEncounter(new Encounter($localPartnet, $scoreLocal, $visitorPartnet, $scoreVisitor))) {
                                    $this->error->setMessage("repeated encounters");
                                    return false;
                                }
                                if ($scoreLocal > $scoreVisitor) {
                                    $localPartnet->scorePoints(ConstantsPaddleLeague::VICTORY);
                                    $visitorPartnet->scorePoints(ConstantsPaddleLeague::DEFEAT);
                                } elseif ($scoreLocal < $scoreVisitor) {
                                    $localPartnet->scorePoints(ConstantsPaddleLeague::DEFEAT);
                                    $visitorPartnet->scorePoints(ConstantsPaddleLeague::VICTORY);
                                } else {
                                    $this->error->setMessage("repeated scores");
                                    return false;
                                }
                            } else {
                                $this->error->setMessage("invalid data");
                                return false;
                            }
                        }


                        $iterationPartnetResult++;
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            $this->error->setMessage($e);
            return false;
        }
    }

    public function responsePaddleLeague()
    {
        $response = '';
        $category = $this->paddleLeague->category;

        foreach ($category as $datacategory) {


            $response = $response . $datacategory->getWinner() . ' ' . $datacategory->getGamesNotPlayed() . "\n";
        }

        return $response;
    }
}

<?php

namespace App\PaddleLeague;

use App\PaddleLeague\Partnet;
use App\PaddleLeague\Encounter;

class Category
{
    public $name;
    public $participants;

    public $encounters;


    public function __construct($name)
    {
        $this->name = $name;
        $this->participants = array();
        $this->encounters = array();
    }


    public function getNumberEncounters()
    {
        return count($this->encounters);
    }



    public function getWinner()
    {

        usort($this->participants, function ($participant_a, $participant_b) {
            return $participant_a->points > $participant_b->points;
        });
        $lengthListParticipants = count($this->participants);

        if (count($this->participants) > 0) {
            if ($this->participants[$lengthListParticipants - 1]->getPoints() == $this->participants[$lengthListParticipants - 2]->getPoints()) {
                return 'EMPATE';
            } else {
                return $this->participants[$lengthListParticipants - 1]->getName();
            }
        } else {
            return '';
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function addParticipant(Partnet $participant)
    {
        $this->participants[] = $participant;
    }

    public function existParticipant($nameParticipant)
    {
        $found_key =  array_search($nameParticipant, array_column($this->participants, 'name'));
        return strlen($found_key) !== 0;
    }

    public function addEncounter(Encounter $encounter)
    {
        if ($this->isLocalOrVisitorEncounter($encounter)) {
            $this->encounters[] = $encounter;
            return true;
        }
        return false;
    }

    public function isLocalOrVisitorEncounter(Encounter $newEncounter)
    {
        foreach ($this->encounters as $encounter) {
            if ($encounter->local->getName() === $newEncounter->local->getName() && $encounter->visitor->getName() === $newEncounter->visitor->getName()) {
                return false;
            }
        }

        return true;
    }


    public function positionParticipant($nameParticipant)
    {
        return array_search($nameParticipant, array_column($this->participants, 'name'));
    }

    public function getGamesNotPlayed()
    {

        $amountOfParticipants = count($this->participants);
        return ($amountOfParticipants * ($amountOfParticipants - 1)) - $this->getNumberEncounters();
    }
}

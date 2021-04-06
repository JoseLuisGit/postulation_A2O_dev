<?php

namespace App\PaddleLeague;

use App\PaddleLeague\Partnet;


class Category
{
    public $name;
    public $participants;
    public $numberOfEncounters;

    public function __construct($name)
    {
        $this->name = $name;
        $this->participants = array();
        $this->numberOfEncounters =  0;
    }


    public function getNumberEncounters()
    {
        return $this->numberOfEncounters;
    }

    public function sumEncounters()
    {
        $this->numberOfEncounters++;
    }

    public function getWinner()
    {

        usort($this->participants, function ($participant_a, $participant_b) {
            return $participant_a->points > $participant_b->points;
        });
        $lengthListParticipants = count($this->participants);
        if ($this->participants[$lengthListParticipants - 1]->getPoints() == $this->participants[$lengthListParticipants - 2]->getPoints()) {
            return 'EMPATE';
        } else {
            return $this->participants[$lengthListParticipants - 1]->getName();
        }
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

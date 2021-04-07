<?php

namespace App\PaddleLeague;

use App\PaddleLeague\Partnet;

class Encounter
{
    public Partnet $local;
    public Partnet $visitor;
    public $pointLocal;
    public $pointVisitor;

    public function __construct($local, $pointLocal, $visitor, $pointVisitor)
    {
        $this->local = $local;
        $this->pointLocal = $pointLocal;
        $this->visitor = $visitor;
        $this->pointVisitor = $pointVisitor;
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueenAttack\ProcessorQueenAttack;

class QueenAttackController extends Controller
{
    //

    public function queenAttack(Request $request)
    {
        $processorQueenAttack = new ProcessorQueenAttack();

        return $processorQueenAttack->processingWord($request->text) ?
            response()->json(['result' => $processorQueenAttack->getSpacesQueenAttack()], 200)
            :
            response()->json(['error' => $processorQueenAttack->error->getMessage()], 422);
    }
}

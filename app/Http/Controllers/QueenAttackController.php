<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\QueenAttack\ProcessorQueenAtack;

class QueenAttackController extends Controller
{
    //

    public function queenAttack(Request $request)
    {
        $processorQueenAttack = new ProcessorQueenAtack();

        return $processorQueenAttack->processingWord($request->text) ?
            response()->json(['result' => $processorQueenAttack->getSpacesQueenAttack()], 200)
            :
            response()->json(['result' => $processorQueenAttack->error->getMessage()], 422);
    }
}

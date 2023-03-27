<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\QueenAttackService;
use Illuminate\Support\Facades\Log;

class QueenAttackController extends Controller
{
    
    protected $queenAttackService;
    
    public function __construct(QueenAttackService $queenAttackService)
    {
        $this->queenAttackService = $queenAttackService;
    }

    public function queenAttack(Request $request)
    {

        $board = $this->queenAttackService->processText($request->text);
        
        if($this->queenAttackService->hasErrors()){
           return response()->json(['error' => $this->queenAttackService->getErrors()], 422);
        }

        return response()->json(['result' => $board->getSpacesQueen(), 'board' => $board->getBoard()], 200);
        
    }
}

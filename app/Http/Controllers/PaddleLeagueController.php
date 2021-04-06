<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaddleLeague\ProcessorPaddleLeague;

class PaddleLeagueController extends Controller
{
    public function paddleLeague(Request $request)
    {

        $processorPaddleLeague = new ProcessorPaddleLeague();
        if ($processorPaddleLeague->processText($request->text)) {
            return response()->json(["result", $processorPaddleLeague->responsePaddleLeague()], 200);
        } else {
            return response()->json(["error", $processorPaddleLeague->error->getMessage()], 422);
        }
    }
}

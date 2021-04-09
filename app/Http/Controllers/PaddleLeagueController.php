<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\PaddleLeague\ProcessorPaddleLeague;

class PaddleLeagueController extends Controller
{
    public function paddleLeague(Request $request)
    {

        $processorPaddleLeague = new ProcessorPaddleLeague();

        return $processorPaddleLeague->processText($request->text) ?
            response()->json(["result" => $processorPaddleLeague->responsePaddleLeague(), 'categories' => $processorPaddleLeague->getCategories()], 200)
            :
            response()->json(["error" => $processorPaddleLeague->error->getMessage()], 422);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\StringValue\ProcessorStringValue;

class StringValueController extends Controller
{
    public function stringValue(Request $request)
    {
        $processorStringValue = new ProcessorStringValue();
        return $processorStringValue->processorStringValue($request->text) ?
            response()->json(['result' => $processorStringValue->getMaxStringValue()], 200) :
            response()->json(['error' => $processorStringValue->error->getMessage()], 422);
    }
}

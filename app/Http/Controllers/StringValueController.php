<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StringValue\StringValueService;

class StringValueController extends Controller
{
    protected StringValueService $stringValueService;

    public function __construct(StringValueService $stringValueService)
    {
        $this->stringValueService = $stringValueService;
    }

    public function stringValue(Request $request)
    {
        $stringValue = $this->stringValueService->processText($request->all());

        if($this->stringValueService->hasErrors()){
            return response()->json( $this->stringValueService->getErrors(), 422);
        }

       return response()->json(['result' => $stringValue->getValueMax(), 'substrings' => $stringValue->getSubStringValues()], 200);

    }
}

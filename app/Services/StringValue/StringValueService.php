<?php
namespace App\Services\StringValue;

use Illuminate\Support\Facades\Validator;
use App\Services\BaseService;
use App\StringValue\StringValue;
use Illuminate\Validation\Rule;

class StringValueService extends BaseService
{

    public function processText(array $data)
    {

        $stringValue = new StringValue();
        $validationRules = [
            'text' => 'required|string|regex:/^[a-z]+$/'
        ];

        $message = [
            'text.regex' => 'The :attribute field must have only lowercase characters'
        ];

        $validator = Validator::make($data, $validationRules);

        if($validator->fails()){
            $this->errors->merge($validator->errors());
        }

        if(!$this->hasErrors()){
            $text = $data['text'];
            $stringValue->generateSubString($text);
        }
        return $stringValue;
    }

}

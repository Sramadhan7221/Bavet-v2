<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class FaqValidator
{
    public static function validate(Request $request): array
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'question' => ['required', 'string'],
                'answer' => ['required', 'string']
            ],
            [
                'question.required' => "Pertanyaan harus diisi",
                'question.string' => "Format Pertanyaan tidak sesuai",
                'answer.required' => "Jawaban harus diisi",
                'answer.string' => "Format Jawaban tidak sesuai"
            ]
        );
        
        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $validatedData = $validator->validated();
        $validatedData['question'] = Purifier::clean($validatedData['question']);
        $validatedData['answer'] = Purifier::clean($validatedData['answer']);
        
        return $validatedData;
    }
}

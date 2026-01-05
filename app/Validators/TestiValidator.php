<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class TestiValidator
{
    public static function validate(Request $request): array
    {
        // dd($id);
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'nama' => ['required', 'string'],
                'profil' => [ 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096'],
                'institusi' => ['required', 'string'],
                'review' => ['required', 'string']
            ],
            [
                'nama.required' => "Nama harus diisi",
                'nama.string' => "Format Nama tidak sesuai",
                'institusi.required' => "Institusi harus diisi",
                'institusi.string' => "Format institusi tidak sesuai",
                'profil.mimes' => "Upload gambar dengan format (jpg, png atau jpeg)",
                'profil.max' => "Upload gambar dengan ukuran kurang dari 4MB",
                'review.required' => "Review harus diisi",
                'review.string' => "Format review tidak sesuai"
            ]
        );
        
        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $validatedData = $validator->validated();
        $validatedData['review'] = Purifier::clean($validatedData['review']);
        
        return $validatedData;
    }
}

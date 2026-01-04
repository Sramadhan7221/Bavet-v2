<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class CarouselBannerValidator
{

    public static function validate(Request $request): array
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'id' => 'nullable',
                'banner' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096']
            ],
            [
                'banner.mimes' => "Upload gambar banner dengan format (jpg, png atau jpeg)",
                'banner.max' => "Upload gambar banner dengan ukuran kurang dari 4MB"
            ]
        );
        
        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $validatedData = $validator->validated();
         
        return $validatedData;
    }
}

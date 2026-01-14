<?php

namespace App\Validators;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class PartnerValidator
{
    public static function validate(Request $request): array
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'id' => 'nullable',
                'nama' => ['required', 'string'],
                'logo' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096'],
                'url' => ['nullable', 'string', 'max:255'],
            ],
            [
                'nama.required' => "Nama Mitra harus diisi",
                'nama.string' => "Format Mitra tidak sesuai",
                'logo.mimes' => "Upload gambar logo dengan format (jpg, png atau jpeg)",
                'logo.max' => "Upload gambar logo dengan ukuran kurang dari 4MB",
                'url.string' => "Format Url mitra tidak sesuai"
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

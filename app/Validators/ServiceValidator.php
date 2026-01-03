<?php

namespace App\Validators;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class ServiceValidator
{
    public static function validate(Request $request): array
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'id' => 'nullable',
                'title' => ['required', 'string'],
                'icon' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096'],
                'banner' => ['nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096'],
                'desc' => ['nullable', 'string', 'max:255'],
                'content' => ['nullable', 'string']
            ],
            [
                'title.required' => "Judul harus diisi",
                'title.string' => "Format Judul tidak sesuai",
                'desc.string' => "Format Deskripsi tidak sesuai",
                'desc.max' => "Deskripsi maksimal 255 karakter",
                'content.string' => "Format Konten tidak sesuai",
                'icon.mimes' => "Upload gambar ikon dengan format (jpg, png atau jpeg)",
                'icon.max' => "Upload gambar ikon dengan ukuran kurang dari 4MB",
                'banner.mimes' => "Upload gambar banner dengan format (jpg, png atau jpeg)",
                'banner.max' => "Upload gambar banner dengan ukuran kurang dari 4MB",
                'content.string' => "Format Konten tidak sesuai"
            ]
        );
        
        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $validatedData = $validator->validated();
        $validatedData['content'] = Purifier::clean($validatedData['content']);
        $validatedData['slug'] = Str::slug($validatedData['title']);
         
        return $validatedData;
    }
}

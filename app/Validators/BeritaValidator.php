<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class BeritaValidator
{
    public static function validate(Request $request, $id = null): array
    {
        $params = $request->all();
        if (isset($params['assets']) && is_string($params['assets'])) {
            $params['assets'] = json_decode($params['assets'], true);
        }
        if (isset($params['delete_assets']) && is_string($params['delete_assets'])) {
            $params['delete_assets'] = json_decode($params['delete_assets'], true);
        }
        if (isset($params['tags']) && is_string($params['tags'])) {
            $params['tags'] = json_decode($params['tags'], true);
        }

        $validator = Validator::make(
            $params,
            [
                'id' => 'nullable',
                'title' => ['required', 'string'],
                'banner' => [ is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:4096'],
                'content' => ['nullable', 'string'],
                // 'is_active' => ['required', Rule::in(['true','false'])],
                'assets' => ['nullable', 'array'],
                'delete_assets' => ['nullable', 'array'],
                'tags' => ['nullable', 'array']
            ],
            [
                'title.required' => "Judul harus diisi",
                'title.string' => "Format Judul tidak sesuai",
                'banner.required' => "Gambar Banner harus diisi",
                'banner.mimes' => "Upload gambar dengan format (jpg, png atau jpeg)",
                'banner.max' => "Upload gambar dengan ukuran kurang dari 4MB",
                'content.string' => "Format Konten tidak sesuai",
                'is_active.required' => "Status aktif harus diisi",
                'is_active.in' => "Format Status aktif tidak sesuai",
                'assets.array' => "Format Aset tidak sesuai",
            ]
        );

        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validated();
        // $cleaningData = Purifier::clean($validatedData['content'], 'question');
        // dd($cleaningData, $validatedData['content']);
        return $validatedData;
    }
}

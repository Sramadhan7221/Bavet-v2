<?php

namespace App\Validators;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class MenuValidator
{
    public static function validate(Request $request, $id): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable',
                'title' => ['required', 'string'],
                'type' => [$id ? 'nullable' : 'required', Rule::in(['static', 'module', 'external'])],
                'external_url' => ['nullable', 'string'],
                'parent_id' => ['nullable'],
                'is_active' => ['required', 'string'],
            ],
            [
                'title.required' => "Judul Menu harus diisi",
                'title.string' => "Format Judul Menu tidak sesuai",
                'type.required' => "Tipe Menu harus diisi",
                'type.in' => "Format Tipe Menu tidak sesuai",
                'is_active.required' => "Status Menu harus dipilih",
            ]
        );

        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validated();
        $validatedData['slug'] = Str::slug($validatedData['title']);

        return $validatedData;
    }
}

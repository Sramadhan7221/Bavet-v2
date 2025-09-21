<?php

namespace App\Validators;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class HomeValidator
{
    public static function validate(Request $request, $id = null): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable',
                'title' => ['required', 'string'],
                'subtitle' => ['required', 'string'],
                'yt_link' => ['required', 'string'],
                'image_hero' => [ is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png', 'max:4096']
            ],
            [
                'title.required' => "Judul Home harus diisi",
                'title.string' => "Format Judul tidak sesuai",
                'subtitle.required' => "Sub judul Home harus diisi",
                'subtitle.string' => "Format Sub judul tidak sesuai",
                'yt_link.required' => "Link Video Home harus diisi",
                'yt_link.string' => "Format Link Video tidak sesuai",
                'image_hero.required' => "Gambar Home harus diisi",
                'image_hero.mimes' => "Upload gambar dengan format (jpg atau png)",
                'image_hero.max' => "Upload gambar dengan ukuran kurang dari 4MB",
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

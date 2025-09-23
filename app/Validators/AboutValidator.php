<?php

namespace App\Validators;

use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AboutValidator
{
    public static function validate(Request $request, $id = null): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable',
                'title' => ['required', 'string'],
                'desc' => ['required', 'string'],
                'visi' => ['required', 'string'],
                'misi' => ['required', 'array'],
                'image_hero' => [ is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:4096'],
                'image_visimisi' => [ is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:4096']
            ],
            [
                'title.required' => "Judul Tentang kami harus diisi",
                'title.string' => "Format Judul tidak sesuai",
                'desc.required' => "Deskripsi Tentang kami harus diisi",
                'desc.string' => "Format Deskripsi tidak sesuai",
                'visi.required' => "Visi harus diisi",
                'visi.string' => "Format Visi tidak sesuai",
                'misi.required' => "Visi harus diisi",
                'image_visimisi.required' => "Gambar Tentang kami harus diisi",
                'image_hero.required' => "Gambar Tentang kami harus diisi",
                'image_hero.mimes' => "Upload gambar dengan format (jpg atau png)",
                'image_hero.max' => "Upload gambar dengan ukuran kurang dari 4MB",
                'image_visimisi.mimes' => "Upload gambar dengan format (jpg atau png)",
                'image_visimisi.max' => "Upload gambar dengan ukuran kurang dari 4MB",
            ]
        );

        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validated();
        $validatedData['misi'] = implode("|",$validatedData['misi']);

        return $validatedData;
    }
}

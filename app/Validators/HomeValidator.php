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
                'subtitle' => ['nullable', 'string'],
                'yt_link' => ['required', 'string'],
                // 'maks_struktural' => ['required', 'number'],
                'image_hero' => [ is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:4096']
            ],
            [
                'title.required' => "Motto harus diisi",
                'title.string' => "Format Motto tidak sesuai",
                // 'subtitle.required' => "Sub judul Home harus diisi",
                'subtitle.string' => "Format Deskripsi tidak sesuai",
                'yt_link.required' => "Link Video Home harus diisi",
                'yt_link.string' => "Format Link Video tidak sesuai",
                // 'maks_struktural.required' => "Jumlah profil struktural yang akan ditampilkan harus diisi",
                // 'maks_struktural.number' => "Masukan format yang valid",
                'image_hero.required' => "Gambar sampul harus diisi",
                'image_hero.mimes' => "Upload gambar sampul dengan format (jpg atau png)",
                'image_hero.max' => "Upload gambar sampul dengan ukuran kurang dari 4MB",
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

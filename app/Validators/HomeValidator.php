<?php
// app/Validators/HomeValidator.php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class HomeValidator
{
    /**
     * Validate hero section
     * 
     * @param Request $request
     * @param int|null $id
     * @return array
     * @throws ValidationException
     */
    public static function validate(Request $request, $id = null): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable|integer',
                'title' => ['required', 'string', 'max:255'],
                'subtitle' => ['nullable', 'string', 'max:500'],
                'yt_link' => ['required', 'string', 'url'],
                'image_hero' => [
                    is_null($id) ? 'required' : 'nullable',
                    'file',
                    'mimes:jpg,png,jpeg,webp',
                    'max:4096' // 4MB
                ]
            ],
            [
                'title.required' => "Motto harus diisi",
                'title.string' => "Format Motto tidak sesuai",
                'title.max' => "Motto maksimal 255 karakter",
                'subtitle.string' => "Format Deskripsi tidak sesuai",
                'subtitle.max' => "Deskripsi maksimal 500 karakter",
                'yt_link.required' => "Link Video Home harus diisi",
                'yt_link.string' => "Format Link Video tidak sesuai",
                'yt_link.url' => "Link Video harus berupa URL yang valid",
                'image_hero.required' => "Gambar sampul harus diisi",
                'image_hero.mimes' => "Upload gambar sampul dengan format (jpg, png, jpeg, atau webp)",
                'image_hero.max' => "Upload gambar sampul dengan ukuran kurang dari 4MB"
            ]
        );

        // Throw validation exception if it fails
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }

    /**
     * Validate Vision & Mission section
     * 
     * @param Request $request
     * @param int|null $id
     * @return array
     * @throws ValidationException
     */
    public static function validateVM(Request $request, $id = null): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable|integer',
                'visi' => ['required', 'string', 'max:1000'],
                'misi' => ['required', 'array', 'min:1'],
                'misi.*' => ['required', 'string', 'max:100'], // Validasi setiap item misi
                'vm_banner' => [
                    is_null($id) ? 'required' : 'nullable',
                    'file',
                    'mimes:jpg,png,jpeg,webp',
                    'max:4096' // 4MB
                ]
            ],
            [
                'visi.required' => "Visi harus diisi",
                'visi.string' => "Format visi tidak sesuai",
                'visi.max' => "Visi maksimal 1000 karakter",
                'misi.required' => "Misi harus diisi",
                'misi.array' => "Format misi tidak sesuai",
                'misi.min' => "Minimal harus ada 1 misi",
                'misi.*.required' => "Setiap item misi harus diisi",
                'misi.*.string' => "Format item misi tidak sesuai",
                'misi.*.max' => "Setiap item misi maksimal 100 karakter",
                'vm_banner.required' => "Gambar sampul harus diisi",
                'vm_banner.mimes' => "Upload gambar sampul dengan format (jpg, png, jpeg, atau webp)",
                'vm_banner.max' => "Upload gambar sampul dengan ukuran kurang dari 4MB"
            ]
        );

        // Throw validation exception if it fails
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $validatedData = $validator->validated();
        
        // Convert array misi menjadi string dengan separator "|"
        $validatedData['misi'] = implode("|", array_filter($validatedData['misi']));

        return $validatedData;
    }

    /**
     * Validate pengujian section
     * 
     * @param Request $request
     * @param int|null $id
     * @return array
     * @throws ValidationException
     */
    public static function validatePengujian(Request $request, $id = null): array
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'nullable|integer',
                'p_hewan' => ['required', 'numeric'],
                'p_produk' => ['required', 'numeric'],
                'p_kesmavet' => ['required', 'numeric'],
                'p_year' => ['required', 'numeric'],
            ],
            [
                'p_hewan.required' => "Jumlah pengujian hewan harus diisi",
                'p_hewan.numeric' => "Format pengujian hewan tidak sesuai",
                'p_produk.required' => "Jumlah pengujian produk hewan harus diisi",
                'p_produk.numeric' => "Format pengujian produk hewan tidak sesuai",
                'p_kesmavet.required' => "Jumlah pengujian kesmavet harus diisi",
                'p_kesmavet.numeric' => "Format pengujian kesmavet tidak sesuai",
                'p_year.required' => "Tahun data harus diisi",
                'p_year.numeric' => "Format tahun data tidak sesuai",
            ]
        );

        // Throw validation exception if it fails
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $validator->validated();
    }
}
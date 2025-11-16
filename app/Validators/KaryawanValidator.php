<?php

namespace App\Validators;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class KaryawanValidator
{
    public static function validate(Request $request, $id = null): array
    {
        // dd($id);
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'id' => 'nullable',
                'nama' => ['required', 'string'],
                'img_profile' => [is_null($id) ? 'required' : 'nullable', 'file', 'mimes:jpg,png,jpeg', 'max:5096'],
                'nip' => ['nullable', 'numeric'],
                'urutan' => ['nullable', 'numeric'],
                'jabatan' => ['required', 'string'],
                'bio' => ['nullable', 'string'],
                'instagram' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?instagram\.com\/[a-zA-Z0-9._]+\/?$/'],
                'facebook' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?(facebook|fb)\.com\/[a-zA-Z0-9._\-]+\/?$/'],
                'tiktok' => ['nullable', 'string', 'regex:/^(https?:\/\/)?(www\.)?tiktok\.com\/@[a-zA-Z0-9._]+\/?$/']
            ],
            [
                'urutan.numeric' => "Urutan tidak sesuai",
                'nama.required' => "Nama harus diisi",
                'nama.string' => "Format Nama tidak sesuai",
                'nip.numeric' => "Format NIP tidak sesuai",
                'jabatan.required' => "Jabatan harus diisi",
                'jabatan.string' => "Format jabatan tidak sesuai",
                'img_profile.required' => "Gambar Profil harus diisi",
                'img_profile.mimes' => "Upload gambar dengan format (jpg, png atau jpeg)",
                'img_profile.max' => "Upload gambar dengan ukuran kurang dari 4MB",
                'bio.string' => "Format Bio tidak sesuai",
                'instagram.string' => "Format Link Instagram tidak sesuai",
                'instagram.regex' => "Link Instagram tidak valid. Contoh: https://instagram.com/username",
                'facebook.string' => "Format Link Facebook tidak sesuai",
                'facebook.regex' => "Link Facebook tidak valid. Contoh: https://facebook.com/username",
                'tiktok.string' => "Format Link Tiktok tidak sesuai",
                'tiktok.regex' => "Link TikTok tidak valid. Contoh: https://tiktok.com/@username",
            ]
        );
        
        // Throw validation exception if it fails (optional)
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
        
        $validatedData = $validator->validated();
        $validatedData['bio'] = Purifier::clean($validatedData['bio']);
        if(isset($validatedData['urutan']) && intval($request->urutan) < 1 && empty($validatedData['id']))
            $validatedData['urutan'] = Karyawan::count()+1;
        
        return $validatedData;
    }
}

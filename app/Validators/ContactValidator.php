<?php

namespace App\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Mews\Purifier\Facades\Purifier;

class ContactValidator
{
    public static function validate(Request $request): array
    {
        $params = $request->all();
        $validator = Validator::make($params, 
            [
                'locations' => 'required|array|size:6',
                'locations.*.id' => 'required|integer|between:1,6',
                'locations.*.alamat' => 'required|string|max:1000',
                'locations.*.telpon' => 'required|string|max:500',
                'locations.*.email' => 'required|string|max:500',
                'locations.*.jam_pelayanan' => 'required|string|max:500',
                'locations.*.location' => 'required|string',
            ], 
            [
                'locations.required' => 'Data lokasi harus diisi',
                'locations.*.alamat.required' => 'Alamat harus diisi',
                'locations.*.telpon.required' => 'Telpon harus diisi',
                'locations.*.email.required' => 'Email harus diisi',
                'locations.*.jam_pelayanan.required' => 'Jam pelayanan harus diisi',
                'locations.*.location.required' => 'Google Maps embed harus diisi',
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

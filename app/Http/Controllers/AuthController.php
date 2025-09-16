<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if($request->method() == "GET"){
            return view('admin.login');
        }
        
        $cred = [];
        try {
            $credentials = $request->validate([
                'username' => ['required'],
                'password' => ['required'],
                // 'g-recaptcha-response' => 'required|captcha'
            ]);
            $cred = ['username' => $credentials['username'], 'password' => $credentials['password']];
        } catch (ValidationException $th) {
            Alert::error('Oops!', $th->getMessage());
            return back();
        }
 
        if (Auth::attempt($cred,isset($request->remember) ? true : false)) {
            $request->session()->regenerate();
            
            return redirect(route('dashboard'));
        }

        Alert::error('Oops!', 'Username atau Password tidak ditemukan');
        return redirect()->back();
    }

    public function logout(Request $request):RedirectResponse
    {
        Auth::logout();
 
        $request->session()->invalidate();
     
        $request->session()->regenerateToken();
     
        Alert::success('Terimakasih !', 'Logout berhasil.');
        return redirect('/login');
    }
}

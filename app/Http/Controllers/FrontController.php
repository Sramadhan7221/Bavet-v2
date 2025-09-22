<?php

namespace App\Http\Controllers;

use App\Models\HomeContent;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        return view('home',[
            'hc' => HomeContent::first()
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FallbackController extends Controller
{
    public function fallback1()
    {
        return view('auth/login');
    }

    public function fallback2()
    {
        (new HomeController)->index();
    }
}

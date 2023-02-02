<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    public function form(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.login');
    }

    public function submit(Request $request)
    {
        $credentials = [
            'email' => trim($request->email),
            'password' => trim($request->password),
            ];

        if( Auth::attempt($credentials)){
            return response()->redirectTo(route('home')) ;
        } else {
            return response()->redirectTo(route('login'))
                ->withErrors('Invalid login or password');
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{

    public function form(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('auth.registration');
    }

    public function submit(Request $request)
    {
        $rules = [
            'name'      =>'required|unique:App\Models\User,name',
            'email'     =>'required|unique:App\Models\User,email',
            'password'  =>'required|confirmed|min:8',
        ];

        $validator = Validator::make($request->all() , $rules);

        if( $validator->fails() )
            return response()->redirectTo( route('registration') )
                ->withErrors($validator);

        User::create([
            'name' => trim($request->name),
            'password' => Hash::make(trim($request->password)),
            'email'    => trim($request->email)
        ]);

        $credentials = [
            'email' => trim($request->email),
            'password' => trim($request->password),
            ];

        if( Auth::attempt($credentials)){
            return response()->redirectTo(route('home')) ;
        } else {
            return response()->redirectTo(route('registration'))
                ->withErrors('Registration failed');
        }
    }
}

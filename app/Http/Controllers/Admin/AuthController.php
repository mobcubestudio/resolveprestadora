<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('admin.login.index');
    }

    public function login(Request $request)
    {
        var_dump($request->all());
        $credentials =[
            'matricula'=>$request->matricula,
            'password'=>$request->password
        ];

        Auth::attempt($credentials);

        return redirect()->route('admin.home');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('admin.home');
    }
}

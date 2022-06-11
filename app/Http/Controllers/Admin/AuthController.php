<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

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


    public function recuperarSenha(Request $request)
    {
        $post = $request->post();

        $funcionario = Employee::where('registration','=',$post['matricula'])
                                ->where('cpf','=',$post['cpf'])
                                ->get();

        if(isset($funcionario[0]->id)){
            $user = User::where('employee_id','=',$funcionario[0]->id)->get()[0];
            $user->password = Hash::make('123456');
            $user->update();
            $res = 'sucesso';
        } else {
            $res = 'erro';
        }

        return $res;


    }
}

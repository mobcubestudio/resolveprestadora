<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function alterarSenha()
    {
        return view('admin.profile.alterar-senha');
    }

    public function alterarSenhaDo(Request $request)
    {
        $senha_antiga = $request->input('old-password');
        $senha_nova = $request->input('new-password');
        $senha_nova_rep = $request->input('rep-new-password');

        $user_data = DB::table('users')->select('password')->where('id',Auth::user()->id);
        if($user_data->count()>0){
            $user = $user_data->first();
            if(Hash::check($senha_antiga,$user->password)==true){
                if($senha_nova != $senha_nova_rep){
                    toastr()->error('Os campos para a nova senha devem ser iguais.');
                } else {
                    $user_alter = User::find(Auth::user()->id);
                    $user_alter->password = Hash::make($senha_nova);
                    $user_alter->save();
                    toastr()->success('Senha alterada com sucesso.');
                }

            } else {
                toastr()->error('A senha antiga está errada.');
            }
        }
        return redirect()->route('admin.profiles.password.alter');
    }
}

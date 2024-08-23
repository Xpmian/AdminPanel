<?php

namespace App\Http\Controllers;

use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function Login(Request $request)
    {
        $name = $request->input('name');
        $psw = $request->input('psw');

        $user = Userss:: where('username', $name)
                         ->where('password', $psw)
                         ->first();

        if($user == null)
        {
            return redirect()->back()->withErrors(['login_error' => 'Kullanıcı adı veya şifre yanlış.']);
        }
        else
        {
            return redirect()->intended('welcome');
        }

    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $name = $request->input('name');
        // $password = bcrypt($request->input('psw'));
        $password = $request->input('psw');

        $user = Userss::  where('username', $name)
                         ->where('password', $password)
                         ->first();

        if($user == null)
        {
            return redirect()->back()->withErrors(['login_error' => 'Kullanıcı adı veya şifre yanlış.']);
        }
        else
        {
            return redirect()->intended('/admin/kullanici-list');
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userss;
use Illuminate\Http\Request;

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
            $user = Userss::where('username',$name)->first();

            session([
                'username' => $user->username,
                'userTitle' => $user->userTitle,
                'slug' => $user->slug
            ]);

            return redirect()->intended('/admin/kullanici-list');
        }
    }
}

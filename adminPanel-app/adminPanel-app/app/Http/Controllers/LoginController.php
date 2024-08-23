<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $user = Userss::where('username', $request->input('name'))->first();

        if(!$user)
        {
            return redirect()->back()->withErrors(['login_error' => 'Kullanıcı adı veya şifre yanlış.']);
        }
        else if($user && Hash::check($request->input('psw'), $user->password))
        {
            session([
                'username' => $user->username,
                'userTitle' => $user->userTitle,
                'slug' => $user->slug
            ]);

            return redirect()->intended('/admin/kullanici-list');
        }
    }

    public function logoff()
    {
        session()->flush();

        return redirect()->route('login.form')->with('success', 'Başarıyla çıkış yapıldı.');
    }
}

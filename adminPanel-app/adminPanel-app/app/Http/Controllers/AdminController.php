<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Userss;
use Doctrine\Inflector\Rules\Turkish\Rules;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use PHPUnit\Metadata\Uses;

class AdminController extends Controller
{
    public function register_user(Request $request)
    {
        // $request->validate([
        //      'userName' => 'required|alpha_num',
        //      'userTitle' => 'required|string',
        //      'password' => 'required|string|min:6',
        // ]);

        $name = $request->input('username');
        $userTitle = $request->input('userTitle');
        $password = $request->input('password');

        $user = Userss:: where('username', $name)->first();

        if($user == null)
        {
            $user = new Userss();

            $user->username = $name;
            $user->userTitle = $userTitle;
            $user->password = bcrypt($password);
            $user->save();

            return redirect()->intended('/admin/kullanici-list');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu username daha önceden kullanılmış']);
        }
    }

    public function show_user_list()
    {
        $users = Userss::all();
        return view("admin.kullanici-list",compact('users'));
    }

    public function show_kullanici_edit($id)
    {
        $user = Userss::find($id);
        if($user)
        {
            return view("admin.kullanici-edit", compact('user'));
            //eğer bir form sayfası açmak istiyorsan, bir view döndürmelisin redirect değil!!!!
        }
        else
        {
            return redirect()->route('kullanici_list')->with('error', 'Kullanıcı bulunamadı.');
        }
    }

    public function register_kullanici_edit(Request $request, $id)
    {
        $existingUser = Userss:: where('username', $request->input('username'))
                                ->where('id', '<>', $id)
                                ->first();
        $user = Userss::find($id);

        if (!$user)
        {
            return redirect()->back()->withErrors(['error' => 'Kullanıcı bulunamadı']);
        }
        if(!$existingUser)
        {
            $user->username = $request->input('username');
            $user->userTitle = $request->input('userTitle');
            if ($request->filled('password'))
            {
                $user->password = bcrypt($request->input('password'));
            }
            $user->save();
        }

        else
        {
            return redirect()->back()->withErrors(['error' => 'Bu isme sahip bir kullanıcı mevcut']);
        }
        return redirect()->route('kullanici_list')->with('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
    }


    public function show_delete_list()
    {
        $users = Userss::all();
        return view("admin.kullanici-sil",compact('users'));
    }

    public function delete_user(Request $request,$id)
    {
        $array = $request->input('user_ids[]');
        dd($array);
        $user = Userss::find($id);
        if ($user)
        {
            $user->delete();
            return redirect()->route('kullanici_list')->with('success', 'Kullanıcı başarıyla silindi.');
        }
        return redirect()->route('kullanici_list')->withErrors(['error' => 'Kullanıcı bulunamadı.']);
    }
}

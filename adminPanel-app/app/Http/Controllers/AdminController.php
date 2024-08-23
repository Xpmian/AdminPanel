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
    public function createSlug($string)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $slug;
    }

    public function show_user_list()
    {
        $users = Userss::orderBy('username', 'asc')->get();

        return view("admin.kullanici.kullanici-list",compact('users'));
    }

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
        $slug = $this->createSlug($name);

        $user = Userss:: where('username', $name)->first();

        if($user == null)
        {
            $user = new Userss();

            $user->username = $name;
            $user->userTitle = $userTitle;
            $user->password = bcrypt($password);
            $user->slug = $slug;
            $user->save();

            return redirect()->intended('/admin/kullanici-list');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu username daha önceden kullanılmış']);
        }
    }

    public function show_kullanici_edit($slug)
    {
        $user = Userss::where('slug',$slug)->first();

        if($user)
        {
            return view("admin.kullanici.kullanici-edit", compact('user'));
            //eğer bir form sayfası açmak istiyorsan, bir view döndürmelisin redirect değil!!!!
        }
        else
        {
            return redirect()->route('kullanici_list')->with('error', 'Kullanıcı bulunamadı.');
        }
    }

    public function register_kullanici_edit(Request $request, $id)
    {
        $existingUser = Userss::where('username', $request->input('username'))
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

            if(!($request->filled('username')) || !($request->filled('userTitle')))
            {
                return redirect()->back()->withErrors(['error' => 'Boş bırakılamaz']);
            }

            if ($request->filled('password'))
            {
                $user->password = bcrypt($request->input('password'));
            }

            $user->slug = $this->createSlug($request->input('username'));

            $username = session('username');
            $sessionUser = Userss::where('username',$username)->first();

            if($id == $sessionUser->id)
            {
                session([
                    'username' => $user->username,
                    'userTitle' => $user->userTitle,
                    'slug' => $user->slug
                ]);
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
        $users = Userss::orderBy('username', 'asc')->get();

        return view("admin.kullanici.kullanici-sil",compact('users'));
    }

    public function delete_user(Request $request,$id)
    {
        $user = Userss::find($id);
        if ($user)
        {
            $user->delete();

            return redirect()->route('kullanici_list')->with('success', 'Kullanıcı başarıyla silindi.');
        }
        return redirect()->route('kullanici_list')->withErrors(['error' => 'Kullanıcı bulunamadı.']);
    }

    public function deleteUserSelect(Request $request)
    {
        $userIds = $request->input('user_ids');

        if (!$userIds)
        {
            return redirect()->back()->withErrors(['error' => 'Silinecek kullanıcı seçilmedi.']);
        }
        Userss::whereIn('id', $userIds)->update(['deleted_at' => now()]);

        return redirect()->route('kullanici_list')->with('success', 'Seçilen kullanıcılar başarıyla silindi.');
    }
}

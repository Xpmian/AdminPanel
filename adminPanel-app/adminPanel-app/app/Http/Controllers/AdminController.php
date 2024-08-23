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
        $turkishChars = array('ş', 'ı', 'İ', 'ğ', 'ü', 'ç', 'ö', 'Ş', 'Ğ', 'Ü', 'Ç', 'Ö');
        $englishChars = array('s', 'i', 'i', 'g', 'u', 'c', 'o', 's', 'g', 'u', 'c', 'o');

        $string = str_replace($turkishChars, $englishChars, $string);

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $slug;
    }

    public function showUserList()
    {
        $users = Userss::orderBy('username', 'asc')->get();

        return view("admin.kullanici.kullanici-list",compact('users'));
    }

    public function registerUser(Request $request)
    {
        $user = Userss:: where('username', $request->input('username'))->first();

        if(!$user)
        {
            $user = new Userss();

            $user->username = $request->input('username');
            $user->userTitle = $request->input('userTitle');
            $user->password = bcrypt($request->input('password'));
            $user->slug = $this->createSlug($request->input('username'));
            $user->save();

            return redirect()->intended('/admin/kullanici-list');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu username daha önceden kullanılmış']);
        }
    }

    public function showUsersCreateForm()
    {
        return view('admin.kullanici.kullanici-ekleme-formu');
    }

    public function showUserEditForm($slug)
    {
        $user = Userss::where('slug', $slug)->firstOrFail();

        return view("admin.kullanici.kullanici-edit", compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $existingUser = Userss::withTrashed()
                       ->where('username', $request->input('username'))
                       ->where('id', '<>', $id)
                       ->first();

        $user = Userss::findOrFail($id);

        if(!$existingUser)
        {
            $user->username = $request->input('username');
            $user->userTitle = $request->input('userTitle');

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

            return redirect()->route('users.list')->with('success', 'Kullanıcı bilgileri başarıyla güncellendi.');
        }
        else
        {
            return redirect()->back()->withErrors(['error' => 'Bu isme sahip bir kullanıcı mevcut']);
        }
    }


    public function showUserDeleteList()
    {
        $users = Userss::orderBy('username','asc')->get();

        return view("admin.kullanici.kullanici-sil",compact('users'));
    }

    public function deleteUser(Request $request,$id)
    {
        $user = Userss::findOrFail($id);

        if($user->username == session('username'))
        {
            session()->flush();
            $user->delete();

            return redirect()->route('login.form')->with('success', 'Başarıyla çıkış yapıldı.');
        }

        $user->delete();

        return redirect()->route('users.list')->with('success', 'Kullanıcı başarıyla silindi.');
    }

    public function deleteSelectedUsers(Request $request)
    {
        $userIds = $request->input('user_ids');

        if (!$userIds)
        {
            return redirect()->back()->withErrors(['error' => 'Silinecek kullanıcı seçilmedi.']);
        }

        Userss::whereIn('id', $userIds)->update(['deleted_at' => now()]);

        return redirect()->route('users.delete.list')->with('success', 'Seçilen kullanıcılar başarıyla silindi.');
    }
}

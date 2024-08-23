<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function kategori_ekleme_show()
    {
        return view('admin.kategori.kategori-ekleme-formu');
    }

    public function kategori_list_show()
    {
        $kategoriler = Category::all();
        return view('admin.kategori.kategori-list', compact('kategoriler'));
    }

    public function kategori_ekleme_register(Request $request)
    {
        $kategori_Adi = $request->input('kategoriAdı');
        $kategori_Aciklamasi = $request->input('kategoriAciklamasi');
        $kategori_status = $request->input('status');

        $category = Category:: where('categoryTitle', $kategori_Adi)->first();

        if($category == null)
        {
            $category = new Category();

            $category->categoryTitle  = $kategori_Adi;
            $category->categoryDescription = $kategori_Aciklamasi;
            $category->status  = $kategori_status;
            $category->save();

            return redirect()->route('show.kategori_list_show')->with('success', 'Kategori bilgileri başarıyla güncellendi.');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu Kategori Adı daha önceden kullanılmış']);
        }
    }

}

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

    public function show_kategori_delete_list()
    {
        $kategoriler = Category::all();
        return view('admin.kategori.kategori-sil', compact('kategoriler'));
    }

    public function delete_kategori($id)
    {
        $category = Category::find($id);

        if ($category)
        {
            $category->delete();
            return redirect()->route('show.kategori_list_show')->with('success', 'kategori başarıyla silindi.');
        }
        return redirect()->route('kategori_list_show')->withErrors(['error' => 'Kategori bulunamadı.']);
    }

    public function show_edit_kategori($id)
    {
        $category = Category::find($id);
        if($category)
        {
            return view("admin.kategori.kategori-edit",compact("category"));
        }
        return redirect()->route('kullanici_list')->with('error', 'Kullanıcı bulunamadı.');
    }

    public function edit_kategori($id,Request $request)
    {
        $existingKategori = Category:: where('categoryTitle', $request->input('kategoriAdı'))
                                      ->where('id', '<>', $id)
                                       ->first();
        $category = Category::find($id);

        if (!$category)
        {
            return redirect()->back()->withErrors(['error' => 'Kategori bulunamadı']);
        }
        if(!$existingKategori)
        {
            if ($request->filled('kategoriAdı') && $request->filled('kategoriAciklamasi'))
            {
                $category->categoryTitle = $request->input('kategoriAdı');
                $category->categoryDescription = $request->input('kategoriAciklamasi');
                $category->status = $request->input('status');

                $category->save();
            }
            else
            {
                return redirect()->back()->withErrors(['error' => 'Boş bırakılamaz']);
            }
        }
        else
        {
            return redirect()->back()->withErrors(['error' => 'Bu isme sahip bir kategori mevcut']);
        }
        return redirect()->route('show.kategori_list_show')->with('success', 'Kategori bilgileri başarıyla güncellendi.');
    }
}

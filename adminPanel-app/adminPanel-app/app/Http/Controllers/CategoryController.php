<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Userss;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    public function createSlug($string)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $slug;
    }

    public function showCategoryList()
    {
        $categories = Category::orderBy('categoryTitle', 'asc')->get();

        return view('admin.kategori.kategori-list', compact('categories'));
    }

    public function showCategoryCreateForm()
    {
        return view('admin.kategori.kategori-ekleme-formu');
    }

    public function registerCategory(Request $request)
    {

        if(!($request->filled('kategoriAdı')) || !($request->filled('kategoriAciklamasi')))
        {
            return redirect()->back()->withErrors(['error' => 'Boş bırakılamaz']);
        }

        $kategori_Adi = $request->input('kategoriAdı');
        $kategori_Aciklamasi = $request->input('kategoriAciklamasi');
        $kategori_status = $request->input('status');
        $slug = $this->createSlug($kategori_Adi);
        
        $category = Category:: where('categoryTitle', $kategori_Adi)->first();

        if($category == null)
        {
            $category = new Category();

            $category->categoryTitle  = $kategori_Adi;
            $category->categoryDescription = $kategori_Aciklamasi;
            $category->status  = $kategori_status;
            $category->slug = $slug;
            $category->save();

            return redirect()->route('show.kategori_list_show')->with('success', 'Kategori bilgileri başarıyla eklendi.');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu Kategori Adı daha önceden kullanılmış']);
        }
    }

    public function showCategoryEditForm($slug)
    {
        $category = Category::where('slug',$slug)->first();

        if($category)
        {
            return view("admin.kategori.kategori-edit",compact("category"));
        }
        else
        {
            abort(404, 'Kategori bulunamadı.');
            // return redirect()->route('show.kategori_list_show')->with('error', 'Kategori bulunamadı.');
        }
    }

    public function updateCategory($id,Request $request)
    {
        $existingKategori = Category:: where('categoryTitle', $request->input('kategoriAdı'))
                                       ->where('id', '<>', $id)
                                       ->first();

        $category = Category::find($id);
        $urunler = Product::where('productCategoryId',$id)->get();

        if (!$category)
        {
            abort(404, 'Kategori bulunamadı.');
            // return redirect()->back()->withErrors(['error' => 'Kategori bulunamadı']);
        }

        if(!$existingKategori)
        {
            if ($request->filled('kategoriAdı') && $request->filled('kategoriAciklamasi'))
            {
                $category->categoryTitle = $request->input('kategoriAdı');
                $category->categoryDescription = $request->input('kategoriAciklamasi');
                $category->status = $request->input('status');
                $category->slug = $this->createSlug($request->input('kategoriAdı'));
                $category->save();

                if($request->input('status') == 0)
                {
                    foreach ($urunler as $urun)
                    {
                        $urun->productStatus = $request->input('status');
                        $urun->save();
                    }
                }
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

    public function showCategoryDeleteList()
    {
        $kategoriler = Category::orderBy('categoryTitle', 'asc')->get();

        return view('admin.kategori.kategori-sil', compact('kategoriler'));
    }

    public function deleteCategory($id)
    {
        $category = Category::find($id);
        $urunler = Product::where('productCategoryId',$id)->orderBy('productTitle', 'asc')
                                                          ->get();

        if ($category)
        {
            $category->delete();
            foreach ($urunler as $urun)
            {
                $urun->productCategoryId = null;
                $urun->save();
            }

            return redirect()->route('show.kategori_list_show')->with('success', 'Kategori başarıyla silindi.');
        }

        // return redirect()->route('kategori_list_show')->withErrors(['error' => 'Kategori bulunamadı.']);
        abort(404, 'Kategori bulunamadı.');
    }

    public function deleteSelectedCategories(Request $request)
    {
        $categoryIds = $request->input('user_ids');

        if (!$categoryIds)
        {
            return redirect()->back()->withErrors(['error' => 'Silinecek kategori seçilmedi.']);
        }

        Category::whereIn('id', $categoryIds)->delete();
        Product::whereIn('productCategoryId', $categoryIds)->update([
            'productCategoryId' => null,
            'productStatus' => 0,
        ]);

        return redirect()->route('show.kategori_list_show')->with('success', 'Seçilen kategoriler başarıyla silindi.');
    }
}

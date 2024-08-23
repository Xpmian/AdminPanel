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
        $turkishChars = array('ş', 'ı', 'İ', 'ğ', 'ü', 'ç', 'ö', 'Ş', 'Ğ', 'Ü', 'Ç', 'Ö');
        $englishChars = array('s', 'i', 'i', 'g', 'u', 'c', 'o', 's', 'g', 'u', 'c', 'o');

        $string = str_replace($turkishChars, $englishChars, $string);

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));

        return $slug;
    }

    public function showCategoryList()
    {
        $categories = Category::orderBy('categoryTitle', 'asc')->whereNull('deleted_at')
                                                                ->get();

        return view('admin.kategori.kategori-list', compact('categories'));
    }

    public function showCategoryCreateForm()
    {
        return view('admin.kategori.kategori-ekleme-formu');
    }

    public function registerCategory(Request $request)
    {
        $slug = $this->createSlug($request->input('categoryname'));

        $existingCategory = Category:: withTrashed()
                                       ->where('categoryTitle', $request->input('categoryname'))->first();

        if(!$existingCategory)
        {
            $category = new Category();

            $category->categoryTitle  = $request->input('categoryname');
            $category->categoryDescription = $request->input('categorydescription');
            $category->status  = $request->input('status');
            $category->slug = $slug;
            $category->save();

            return redirect()->route('categories.list')->with('success', 'Kategori bilgileri başarıyla eklendi.');
        }
        else
        {
            return redirect()->back()->withErrors(['login_error' => 'Bu Kategori Adı daha önceden kullanılmış']);
        }
    }

    public function showCategoryEditForm($slug)
    {
        $category = Category::where('slug',$slug)->firstOrFail();

        return view("admin.kategori.kategori-edit",compact("category"));
    }

    public function updateCategory($id,Request $request)
    {
        $existingCategory = Category:: withTrashed()
                                       ->where('categoryTitle', $request->input('categoryname'))
                                       ->where('id', '<>', $id)
                                       ->first();

        $category = Category::find($id);

        $products = Product::where('productCategoryId',$id)->get();

        if(!$existingCategory)
        {
            $category->categoryTitle = $request->input('categoryname');
            $category->categoryDescription = $request->input('categorydescription');
            $category->status = $request->input('status');
            $category->slug = $this->createSlug($request->input('categoryname'));

            $category->save();

            if($request->input('status') == 0)
            {
                foreach ($products as $urun)
                {
                    $urun->productStatus = $request->input('status');
                    $urun->save();
                }
            }

            return redirect()->route('categories.list')->with('success', 'Kategori bilgileri başarıyla güncellendi.');
        }
        else
        {
            return redirect()->back()->withErrors(['error' => 'Bu isme sahip bir kategori mevcut']);
        }
    }

    public function showCategoryDeleteList()
    {
        $categories = Category::orderBy('categoryTitle', 'asc')->whereNull('deleted_at')
                                                               ->get();

        return view('admin.kategori.kategori-sil', compact('categories'));
    }

    public function deleteCategory($id)
    {
        $category = Category::findorFail($id);
        $products = Product::where('productCategoryId',$id)->orderBy('productTitle', 'asc')
                                                           ->get();

        if ($category)
        {
            $category->delete();
            foreach ($products as $product)
            {
                $product->productCategoryId = null;
                $product->save();
            }

            return redirect()->route('categories.list')->with('success', 'Kategori başarıyla silindi.');
        }
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

        return redirect()->route('categories.delete.list')->with('success', 'Seçilen kategoriler başarıyla silindi.');
    }
}

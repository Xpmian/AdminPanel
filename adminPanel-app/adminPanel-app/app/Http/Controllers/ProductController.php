<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function showProductRegister()
    {
        $kategoriler = Category::where('status',1)->get();
        return view('admin.product.urun-ekleme-formu',['kategoriler' => $kategoriler]);
    }

    public function register_product(Request $request)
    {
        $urun_adi = $request->input('ProductTitle');
        $urun_kategori_id = $request->input('ProductCategoryId');
        $barkod = $request->input('Barcode');
        $durum = $request->input('status');

        $product = new Product();
        $product->productTitle = $urun_adi;
        $product->productCategoryId = $urun_kategori_id;
        $product->barcode = $barkod;
        $product->productStatus = $durum;

        $product->save();
        return redirect()->route('show.urun_list_show')->with('success', 'Kategori bilgileri başarıyla eklendi.');
    }

    public function urun_list_show()
    {
        $urunler = Product::all();
        return view('admin.product.urun-list',['urunler' => $urunler]);
    }

    public function show_edit_urun($id)
    {
        $urun = Product::find($id);
        $kategoriler = Category::where('status',1)->get();
        if($urun)
        {
            return view('admin.product.urun-edit',compact('urun','kategoriler'));
        }
        return redirect()->route('showProduct')->with('error', 'Ürün bulunamadı.');
    }

    public function edit_urun(Request $request ,$id)
    {
        $urun = Product::find($id);
        if(!$urun)
        {
            return redirect()->back()->withErrors(['error' => 'Ürün bulunamadı']);
        }
        else
        {
            if($request->filled('ProductTitle') && $request->filled('Barcode'))
            {
                $urun->productTitle = $request->input('ProductTitle');
                $urun->productCategoryId = $request->input('ProductCategoryId');
                $urun->barcode = $request->input('Barcode');
                $urun->productStatus = $request->input('status');

                $urun->save();
            }
            else
            {
                return redirect()->back()->withErrors(['error' => 'Boş bırakılamaz']);
            }
        }
        return redirect()->route('show.urun_list_show')->with('success', 'Ürün bilgileri başarıyla güncellendi.');
    }

    public function show_urun_delete_list()
    {
        $urunler = Product::all();
        return view('admin.product.urun-sil',compact('urunler'));
    }

    public function delete_urun($id)
    {
        $urun = Product::find($id);

        if ($urun)
        {
            $urun->delete();
            return redirect()->route('show.urun_list_show')->with('success', 'Ürün başarıyla silindi.');
        }
        return redirect()->route('show.urun_list_show')->withErrors(['error' => 'Ürün bulunamadı.']);
    }

    public function deleteProductSelect(Request $request)
    {
        $productIds = $request->input('user_ids');

        if (!$productIds)
        {
            return redirect()->back()->withErrors(['error' => 'Silinecek ürün seçilmedi.']);
        }

        Product::whereIn('id', $productIds)->delete();

        return redirect()->route('show.urun_list_show')->with('success', 'Seçilen ürünler başarıyla silindi.');
    }
}

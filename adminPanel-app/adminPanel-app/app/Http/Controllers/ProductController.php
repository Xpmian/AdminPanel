<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use GuzzleHttp\Handler\Proxy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function createSlug($string, $id)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
        $slug .= '-' . $id;

        return $slug;
    }

    public function urun_list_show()
    {
        $urunler = DB::table('product_category_view')->orderBy('productTitle', 'asc')
                                                     ->get();

        $kategoriler = Category::all();

        return view('admin.product.urun-list',compact('urunler','kategoriler'));
    }

    public function filter_category(Request $request)
    {
        $kategori_id = $request->input('categoryId');

        $urunler = DB::table('product_category_view')
                    ->where('category_id', $kategori_id)
                    ->orderBy('productTitle', 'asc')
                    ->get();

        $kategoriler = Category::all();

        return view('admin.product.urun-list', compact('urunler', 'kategoriler'))->with('success', 'Kategori bilgileri başarıyla Filtrenlendi.');
    }

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
        $durum = $request->input('Status');
        $fiyat = $request->input('Price');
        $stok = $request->input('Stock');

        $product_barcode = Product::where('barcode',$barkod)->first();

        if(!$product_barcode)
        {
            $product = new Product();
            $product->productTitle = $urun_adi;
            $product->productCategoryId = $urun_kategori_id;
            $product->barcode = $barkod;
            $product->productStatus = $durum;
            $product->price = $fiyat;
            $product->stock = $stok;
            $product->save();

            $product->slug = $this->createSlug($urun_adi, $product->id);
            $product->save();

            return redirect()->route('show.urun_list_show')->with('success', 'Ürün başarıyla eklendi.');
        }
        else
        {
            return redirect()->route('show.urun_list_show')->with('error', 'Bu barkod numarasına bir sahip ürün var.');
        }
    }

    public function show_edit_urun($slug)
    {
        $urun = Product::where('slug',$slug)->first();
        $kategoriler = Category::all();

        if($urun)
        {
            return view('admin.product.urun-edit',compact('urun','kategoriler'));
        }
        else
        {
            abort(404, 'Kategori bulunamadı.');
            // return redirect()->route('show.urun_list_show')->with('error', 'Ürün bulunamadı.');
        }
    }

    public function edit_urun(Request $request ,$id)
    {
        $urunStatus = $request->input('status');
        $categoryId = $request->input('ProductCategoryId');
        $barcode = $request->input('Barcode');

        $urun = Product::find($id);
        $existingUser = Product::where('barcode', $barcode)
                       ->where('id', '<>', $id)
                       ->first();

        if(!$urun)
        {
            abort(404, 'Ürün bulunamadı.');
            // return redirect()->back()->withErrors(['error' => 'Ürün bulunamadı']);
        }
        else if($existingUser)
        {
            return redirect()->back()->withErrors(['error' => 'Bu barkod numarasın sahip bir ürün var!']);
        }
        else
        {
            if($request->filled('ProductTitle') && $request->filled('Barcode') && $request->filled('price') && $request->filled('stock'))
            {
                $urun->productTitle = $request->input('ProductTitle');
                $urun->productCategoryId = $categoryId;
                $urun->barcode = $request->input('Barcode');
                $urun->productStatus = $request->input('status');
                $urun->price = $request->input('price');
                $urun->stock = $request->input('stock');
                $urun->slug = $this->createSlug($request->input('ProductTitle'),$id);
                $urun->save();

                if($urunStatus == 1)
                {
                    $kategori = Category::where('id',$categoryId)->first();

                    $kategori->status = 1;
                    $kategori->save();
                }
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
        $urunler = DB::table('product_category_view')->orderBy('productTitle', 'asc')
                                                     ->get();

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

    public function show_image_upload($slug)
    {
        $product = Product::where('slug',$slug)->first();
        $productImages = ProductImages::where('slug',$slug)->get();

        return view('admin.product.urun-image',compact('product','productImages'));
    }

    public function image_upload(Request $request,$slug)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:png,jpg,jpeg,webp'
        ]);

        $product = Product::where('slug',$slug)->firstOrFail();

        $imageData = [];
        $files = $request->file('images');

        if($files)
        {
            foreach($files as $key => $file)
            {
                $extension = $file->getClientOriginalExtension();
                $fileName = $key. '-' .time(). '-' .$extension;

                $path = "uploads/products/";
                $file->move($path, $fileName);

                $imageData[] = [
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                    'image' => $path.$fileName
                ];
            }
        }
        ProductImages::insert($imageData);

        return redirect()->route('image_upload',$slug)->with('success', 'Görsel başarıyla yüklendi.');
    }

    public function image_delete($id)
    {
        $productImage = ProductImages::find($id);
        $slug = $productImage->slug;

        if(File::exists($productImage->image))
        {
            File::delete($productImage->image);
        }

        $productImage->delete();

        return redirect()->route('image_upload',$slug)->with('success', 'Görsel başarıyla Silindi.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    public function createSlug($string, $id)
    {
        $turkishChars = array('ş', 'ı', 'İ', 'ğ', 'ü', 'ç', 'ö', 'Ş', 'Ğ', 'Ü', 'Ç', 'Ö');
        $englishChars = array('s', 'i', 'i', 'g', 'u', 'c', 'o', 's', 'g', 'u', 'c', 'o');

        $string = str_replace($turkishChars, $englishChars, $string);

        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $string)));
        $slug .= '-' . $id;

        return $slug;
    }

    public function showProductList()
    {
        $products = DB::table('product_category_view')->whereNull('deleted_at')
                                                      ->orderBy('productTitle', 'asc')
                                                      ->get();
        $categories = Category::all();

        return view('admin.product.urun-list', compact('products', 'categories'));
    }

    public function filterByCategory(Request $request)
    {
        $categoryId = $request->input('categoryId');

        $products = DB::table('product_category_view')
                            ->where('category_id', $categoryId)
                            ->orderBy('productTitle', 'asc')
                            ->get();

        $categories = Category::all();

        return view('admin.product.urun-list', compact('products', 'categories'))->with('success', 'Kategori bilgileri başarıyla filtrelendi.');
    }

    public function showProductRegisterForm()
    {
        $categories = Category::all();

        return view('admin.product.urun-ekleme-formu', ['categories' => $categories]);
    }

    public function registerProduct(Request $request)
    {
        $existingProduct = Product::withTrashed()
                                    ->where('barcode', $request->input('Barcode'))->first();

        if (!$existingProduct)
        {
            $product = new Product();
            $product->productTitle = $request->input('ProductTitle');
            $product->productCategoryId = $request->input('ProductCategoryId');
            $product->barcode = $request->input('Barcode');
            $product->productStatus = $request->input('Status');
            $product->price = $request->input('Price');
            $product->stock = $request->input('Stock');
            $product->save();

            $product->slug = $this->createSlug($request->input('ProductTitle'), $product->id);
            $product->save();

            if ($request->input('Status') == 1)
            {
                $category = Category::where('id', $request->input('ProductCategoryId'))->first();
                $category->status = 1;

                $category->save();
            }

            return redirect()->route('products.list')->with('success', 'Ürün başarıyla eklendi.');
        }

        else
        {
            return redirect()->route('products.create.form')->with('error', 'Bu barkod numarasına sahip bir ürün zaten var.');
        }
    }

    public function showProductEdit($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = Category::all();

        return view('admin.product.urun-edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $existingProduct = Product::withTrashed()
                                   ->where('barcode', $request->input('Barcode'))
                                   ->where('id', '<>', $id)
                                   ->first();

        if ($existingProduct)
        {
            return redirect()->back()->withErrors(['error' => 'Bu barkod numarasına sahip bir ürün var!']);
        }
        else
        {
            $product->productTitle = $request->input('ProductTitle');
            $product->productCategoryId = $request->input('ProductCategoryId');
            $product->barcode = $request->input('Barcode');
            $product->productStatus = $request->input('status');
            $product->price = $request->input('price');
            $product->stock = $request->input('stock');
            $product->slug = $this->createSlug($request->input('ProductTitle'), $id);
            $product->save();

            if ($request->input('status') == 1)
            {
                $category = Category::where('id', $request->input('ProductCategoryId'))->first();
                $category->status = 1;

                $category->save();
            }

            return redirect()->route('products.list')->with('success', 'Ürün bilgileri başarıyla güncellendi.');
        }
    }

    public function showProductDeleteList()
    {
        $products = DB::table('product_category_view')->whereNull('deleted_at')
                                                      ->orderBy('productTitle', 'asc')
                                                      ->get();

        return view('admin.product.urun-sil',compact('products'));
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('products.list')->with('success', 'Ürün başarıyla silindi.');

    }

    public function deleteSelectedProducts(Request $request)
    {
        $productIds = $request->input('user_ids');
        if (!$productIds)
        {
            return redirect()->back()->withErrors(['error' => 'Silinecek ürün seçilmedi.']);
        }

        Product::whereIn('id', $productIds)->delete();

        return redirect()->route('products.delete.list')->with('success', 'Seçilen ürünler başarıyla silindi.');
    }

    public function showImageUpload($slug)
    {
        $product = Product::where('slug', $slug)->first();
        $productImages = ProductImages::where('slug', $slug)->get();

        return view('admin.product.urun-image', compact('product', 'productImages'));
    }

    public function uploadImage(Request $request, $slug)
    {
        $request->validate([
            'images.*' => 'required|image|mimes:png,jpg,jpeg,webp'
        ]);

        $product = Product::where('slug', $slug)->firstOrFail();

        $imageData = [];
        $files = $request->file('images');

        if ($files)
        {
            foreach ($files as $key => $file)
            {
                $extension = $file->getClientOriginalExtension();
                $fileName = $key . '-' . time() . '-' . $extension;
                $path = "uploads/products/";
                $file->move($path, $fileName);

                $imageData[] = [
                    'product_id' => $product->id,
                    'slug' => $product->slug,
                    'image' => $path . $fileName
                ];
            }
        }

        ProductImages::insert($imageData);

        return redirect()->route('products.image.upload', $slug)->with('success', 'Görsel başarıyla yüklendi.');
    }

    public function deleteImage($id)
    {
        $productImage = ProductImages::find($id);
        $slug = $productImage->slug;

        if (File::exists($productImage->image))
        {
            File::delete($productImage->image);
        }

        $productImage->delete();

        return redirect()->route('products.image.upload', $slug)->with('success', 'Görsel başarıyla silindi.');
    }
}

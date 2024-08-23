@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kullanici-ekleme-formu.css') }}">
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-container">
        <form action="{{ route('products.update', $product->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Ürün Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="ProductTitle" id="ProductTitle" value="{{ $product->productTitle }}" class="form-control" required>
            </div>

            <label>Ürün Kategori :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="ProductCategoryId" class="form-control">
                    @foreach ($categories as $categorie )
                    <option value="{{ $categorie->id }}" {{ $product->productCategoryId == $categorie->id ? 'selected' : '' }}>
                        {{ $categorie->categoryTitle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <label>Ürün Barcode :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" name="Barcode" id="Barcode" value="{{ $product->barcode }}" class="form-control" required>
            </div>

            <label>Ürün Durum :</label>
            <div class="form-block">
                <div class="input-group mb-3 mt-2">
                    <select id="number-select" name="status" class="form-control">
                        <option style="color: red; font-weight: bold;" value="0" {{ $product->productStatus == 0 ? 'selected' : '' }}>Pasif</option>
                        <option style="color: green; font-weight: bold;" value="1" {{ $product->productStatus == 1 ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
            </div>

            <label>Ürün Fiyatı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" name="price" id="price" value="{{ $product->price }}" class="form-control" required>
            </div>

            <label>Ürün Stoğu :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" name="stock" id="stock" value="{{ $product->stock }}" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom">Güncelle</button>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/kullanici-ekleme-formu.css') }}">
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="form-container">
        <form action="{{ route('products.create') }}" method="POST">
            @csrf
            <label>Ürün Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" class="form-control" placeholder="Ürün Adı " name="ProductTitle" required>
            </div>

            <label>Ürün Kategori ID :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="ProductCategoryId" class="form-control">
                    @foreach ($categories as $categorie )
                        <option value="{{$categorie->id}}">{{$categorie->categoryTitle}}</option>
                    @endforeach
                </select>
            </div>

            <label>Barcode :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" class="form-control" placeholder="Ürün Barkodu" name="Barcode" required>
            </div>
            <label>Ürün Durumu :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="Status"  class="form-control">
                    <option value="0" style="color: red; font-weight: bold;">Pasif</option>
                    <option value="1" style="color: green; font-weight: bold;">Aktif</option>
                </select>
            </div>
            <label>Fiyat :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" class="form-control" placeholder="Ürün Fiyatı" name="Price" required>
            </div>
            <label>Stok :</label>
            <div class="input-group mb-3 mt-2">
                <input type="number" class="form-control" placeholder="Ürün Stoğu" name="Stock" required>
            </div>
            <button type="submit" class="btn btn-custom mt-3">Kaydet</button>
        </form>
    </div>
@endsection

@section('js')
@endsection

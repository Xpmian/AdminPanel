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
        <form action="{{ route('edit.urun', $urun->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Ürün Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="ProductTitle" id="ProductTitle" value="{{ $urun->productTitle }}" class="form-control">
            </div>

            <label>Ürün Kategori :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="ProductCategoryId" class="form-control">
                    @foreach ($kategoriler as $kategori )
                    <option value="{{ $kategori->id }}" {{ $urun->productCategoryId == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->categoryTitle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <label>Ürün Barcode :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="Barcode" id="Barcode" value="{{ $urun->barcode }}" class="form-control">
            </div>

            <label>Ürün Durum :</label>
            <div class="form-block">
                <div class="input-group mb-3 mt-2">
                    <select id="number-select" name="status" class="form-control">
                        <option style="color: red; font-weight: bold;" value="0" {{ $urun->productStatus == 0 ? 'selected' : '' }}>Pasif</option>
                        <option style="color: green; font-weight: bold;" value="1" {{ $urun->productStatus == 1 ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
            </div>

            <label>Ürün Fiyatı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="price" id="price" value="{{ $urun->price }}" class="form-control">
            </div>

            <label>Ürün Stoğu :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="stock" id="stock" value="{{ $urun->stock }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-custom">Güncelle</button>
        </form>
    </div>
@endsection

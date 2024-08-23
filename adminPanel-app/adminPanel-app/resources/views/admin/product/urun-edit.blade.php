@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kullanici-ekleme-formu.css') }}">
@endsection

@section('content')
    <h2 class="centered-title">Ürün Düzenle</h2>
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

            <label>Ürün Kategori ID :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="ProductCategoryId" class="form-control">
                    @foreach ($kategoriler as $kategori )
                    <option value="{{ $kategori->id }}" {{ $urun->productCategoryId == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->categoryTitle }}
                    </option>
                    @endforeach
                </select>
            </div>

            <label>Barcode :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="Barcode" id="Barcode" value="{{ $urun->barcode }}" class="form-control">
            </div>

            <label>Durum:</label>
            <div class="form-block">
                <div class="input-group mb-3 mt-2">
                    <select id="number-select" name="status" class="form-control">
                        <option value="0" {{ $urun->productStatus == 0 ? 'selected' : '' }}>0</option>
                        <option value="1" {{ $urun->productStatus == 1 ? 'selected' : '' }}>1</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-custom mt-3">Güncelle</button>
        </form>
    </div>
@endsection

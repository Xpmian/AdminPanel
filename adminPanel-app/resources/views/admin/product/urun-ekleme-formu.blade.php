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
        <form action="{{ route('registerProduct') }}" method="POST">
            @csrf
            <label>Ürün Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" class="form-control" placeholder="Ürün Adı " name="ProductTitle">
            </div>

            <label>Ürün Kategori ID :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="ProductCategoryId" class="form-control">
                    @foreach ($kategoriler as $kategori )
                        <option value="{{$kategori->id}}">{{$kategori->categoryTitle}}</option>
                    @endforeach
                </select>
            </div>

            <label>Barcode :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" class="form-control" placeholder="Ürün Barkodu" name="Barcode">
            </div>
            <label>Ürün Durumu :</label>
            <div class="input-group mb-3 mt-2">
                <select id="number-select" name="status"  class="form-control">
                    <option value="0" style="color: red; font-weight: bold;">Pasif</option>
                    <option value="1" style="color: green; font-weight: bold;">Aktif</option>
                </select>
            </div>
            <button type="submit" class="btn btn-custom mt-3">Kaydet</button>
        </form>
    </div>
@endsection

@section('js')
@endsection

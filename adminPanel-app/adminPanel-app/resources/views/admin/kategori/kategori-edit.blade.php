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
        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Kategori Adı :</label>

            <div class="input-group mb-3 mt-2">
                <input type="text" name="categoryname" id="categoryname" value="{{ $category->categoryTitle }}" class="form-control">
            </div>

            <label>Kategori Açıklaması :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="categorydescription" id="categorydescription" value="{{ $category->categoryDescription }}" class="form-control">
            </div>

            <label>Durum :</label>
            <div class="form-block">
                <div class="input-group mb-3 mt-2">
                    <select id="number-select" name="status" class="form-control">
                        <option style="color: red; font-weight: bold;" value="0" {{ $category->status == 0 ? 'selected' : '' }}>Pasif</option>
                        <option style="color: green; font-weight: bold;" value="1" {{ $category->status == 1 ? 'selected' : '' }}>Aktif</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-custom mt-3">Güncelle</button>
        </form>
    </div>
@endsection

@extends('layouts.admin')

@section('content')
    <h2>Kategoriyi Düzenle</h2>

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

    <form action="{{ route('edit.kategori', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="username">Kategori Adı:</label>
            <input type="text" name="kategoriAdı" id="kategoriAdı" value="{{ $category->categoryTitle }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="userTitle">Kategori Açıklaması:</label>
            <input type="text" name="kategoriAciklamasi" id="kategoriAciklamasi" value="{{ $category->categoryDescription }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="userTitle">Durum:</label>
            <div class="input-group mb-3">
                <select id="number-select" name="status">
                    <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>0</option>
                    <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>1</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
@endsection

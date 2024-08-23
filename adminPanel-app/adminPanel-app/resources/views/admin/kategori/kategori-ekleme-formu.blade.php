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

    <form action="{{ route('register.kategori_ekleme_formu') }}" method="POST">
        @csrf
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Kategori Adı " name="kategoriAdı">
        </div>
        <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Kategori Açıklaması " name="kategoriAciklamasi">
        </div>
        <div class="input-group mb-3">
            <select id="number-select" name="status">
                <option value="0">0</option>
                <option value="1">1</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kaydet</button>
    </form>
@endsection

@section('js')
@endsection

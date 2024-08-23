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
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <label>Kullanıcı Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" class="form-control" placeholder="Kullanıcı Adı" name="username" required>
            </div>
            <label>Kullanıcı Title :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" class="form-control" placeholder="Kullanıcı Title" name="userTitle" required>
            </div>
            <label>Şifre :</label>
            <div class="input-group mb-3 mt-2">
                <input type="password" class="form-control" placeholder="Şifre" name="password">
            </div>
            <button type="submit" class="btn btn-custom mt-3">Kaydet</button>
        </form>
    </div>
@endsection

@section('js')
@endsection

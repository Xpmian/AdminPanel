@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <link rel="stylesheet" href="{{ asset('css/kullanici-ekleme-formu.css') }}">
@endsection

@section('content')
    {{-- <h2 class="centered-title">Kullanıcı Düzenle</h2> --}}

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
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label >Kullanıcı Adı :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control" required>
            </div>

            <label>Kullanıcı Title :</label>
            <div class="input-group mb-3 mt-2">
                <input type="text" name="userTitle" id="userTitle" value="{{ $user->userTitle }}" class="form-control" required>
            </div>

            <label>Şifre:</label>
            <div class="input-group mb-3 mt-2">
                <input type="password" name="password" id="password" class="form-control">
            </div>

            <button type="submit" class="btn btn-custom mt-3">Güncelle</button>
        </form>

@endsection

@extends('layouts.admin')

@section('content')
    <h2>Kullanıcıyı Düzenle</h2>

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

    <form action="{{ route('edit.register', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="username">Kullanıcı Adı:</label>
            <input type="text" name="username" id="username" value="{{ $user->username }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="userTitle">Kullanıcı Title:</label>
            <input type="text" name="userTitle" id="userTitle" value="{{ $user->userTitle }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Şifre:</label>
            <input type="text" name="password" id="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Güncelle</button>
    </form>
@endsection

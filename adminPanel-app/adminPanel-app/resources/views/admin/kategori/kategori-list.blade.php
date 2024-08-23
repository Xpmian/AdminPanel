@extends('layouts.admin')

@section('css')

@endsection

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">Kategoriler</h2>

        <form action="{{ route('kullanici_list') }}" method="POST" id="softdelete-form">
            @csrf
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kategori Adı</th>
                        <th>Kullanıcı Açıklaması</th>
                        <th>Durum</th>
                        <th>Düzenle</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoriler as $kategori)
                        <tr>
                            <td>{{ $kategori->categoryTitle }}</td>
                            <td>{{ $kategori->categoryDescription }}</td>
                            <td>{{ $kategori->status }}</td>
                            <td><a href="{{ route('show.edit', $kategori->id) }}" class="btn btn-warning btn-sm">Düzenle</a></td>
                            <td><a href="{{route('kullanici_sil_list')}}" class="btn btn-warning btn-sm">Sil</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

    @section('js')
    @endsection
@endsection

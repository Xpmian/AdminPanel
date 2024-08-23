@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endsection

@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success text-succes">
                {{ session('success') }}
            </div>
        @endif
        <div class="containerTotal">

            <div class="containerUp">
                <div class="item-th">Kategori Adı</div>
                <div class="item-th">Kategori Açıklaması</div>
                <div class="item-th">Durum</div>
                <div class="item-th">Düzenle</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">
                <form id="softdelete-form">
                    @csrf
                    <table>
                        @foreach ($kategoriler as $kategori)
                            <tr class="trCompany">
                                <td>{{ $kategori->categoryTitle }}</td>
                                <td>{{ $kategori->categoryDescription }}</td>
                                @if ($kategori->status == 1)
                                    <td>Aktif</td>
                                @elseif ($kategori->status == 0)
                                    <td>Pasif</td>
                                @endif
                                <td><a href="{{ route('show.edit_kategori', $kategori->id) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
                                <td><a href="{{ route('kategori_sil',$kategori->id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                </form>

            </div>
        </div>
    </div>
@endsection

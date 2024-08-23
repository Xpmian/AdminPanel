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
        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
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
                        @foreach ($categories as $category)
                            <tr class="trCompany">
                                <td>{{ $category->categoryTitle }}</td>
                                <td>{{ $category->categoryDescription }}</td>
                                @if ($category->status == 1)
                                <td style="color: green; font-weight: bold;">Aktif</td>
                                @elseif ($category->status == 0)
                                <td style="color: red; font-weight: bold;">Pasif</td>
                                @endif
                                <td><a href="{{ route('show.edit_kategori', $category->slug) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
                                <td><a href="{{ route('kategori_sil',$category->id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                </form>

            </div>
        </div>
    </div>
@endsection

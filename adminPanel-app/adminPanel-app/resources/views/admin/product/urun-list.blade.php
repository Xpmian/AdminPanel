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

            <div class="containerUpProduct">
                <div class="item-th">Ürün Adı</div>
                <div class="item-th">Ürün Kategori ID</div>
                <div class="item-th">Ürün Barkodu</div>
                <div class="item-th">Ürün Durumu</div>
                <div class="item-th">Düzenle</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">

                <form id="softdelete-form">
                    @csrf
                    <table>
                        @foreach ($urunler as $urun)
                            <tr class="trCompanyProduct">
                                <td>{{ $urun->productTitle }}</td>
                                @if ($urun->productCategoryId == null)
                                    <td>Kategori Silindi</td>
                                @endif
                                <td>{{ $urun->productCategoryId }}</td>
                                <td>{{ $urun->barcode }}</td>
                                @if ($urun->productStatus == 1)
                                    <td>Aktif</td>
                                @elseif ($urun->productStatus == 0)
                                    <td>Pasif</td>
                                @endif
                                <td><a href="{{ route('show.edit_urun', $urun->id) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
                                <td><a href="{{ route('urun_sil',$urun->id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                </form>

            </div>
        </div>
    </div>
@endsection

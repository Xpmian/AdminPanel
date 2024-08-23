@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    <style>
        .filter-container {
            display: flex;
            align-items: center;
            gap: 10px; /* Elemanlar arasında boşluk */
            margin-bottom: 20px;
        }

        .filter-container select {
            width: 50%;
        }

        .filter-container button {
            background-color: #ff0000;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
        }

        .filter-container button:hover {
            background-color: #cc0000;
        }
    </style>
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

            <form method="POST">
                @csrf
                <div class="filter-container">
                    <select id="number-select" name="categoryId" class="form-control">
                        @foreach ($kategoriler as $kategori )
                            <option value="{{ $kategori->id }}">{{ $kategori->categoryTitle }}</option>
                        @endforeach
                    </select>

                    <button type="submit" class="btn btn-primary" style="background-color: #3d759a">Filtrele</button>
                    <a href="{{route('show.urun_list_show')}}"  class="btn btn-primary" style="background-color: #3d759a">Hepsini Göster</a>
                </div>
            </form>

            <div class="containerUpProduct">
                <div class="item-th">Ürün Adı</div>
                <div class="item-th">Ürün Kategori</div>
                <div class="item-th">Ürün Barkodu</div>
                <div class="item-th">Ürün Durumu</div>
                <div class="item-th">Ürün Fiyatı</div>
                <div class="item-th">Ürün Stoğu</div>
                <div class="item-th">Resim</div>
                <div class="item-th">Düzenle</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">
                <form id="softdelete-form">
                    @csrf
                    <table class="formtable" id="productTable">
                        @foreach ($urunler as $urun)
                            <tr class="trCompanyProduct">
                                <td>{{ $urun->productTitle }}</td>
                                @if ($urun->categoryTitle == null)
                                    <td>Kategori Silindi</td>
                                @else
                                    <td>{{ $urun->categoryTitle }}</td>
                                @endif
                                <td>{{ $urun->barcode }}</td>
                                @if ($urun->productStatus == 1)
                                    <td style="color: green; font-weight: bold;">Aktif</td>
                                @elseif ($urun->productStatus == 0)
                                    <td style="color: red; font-weight: bold;">Pasif</td>
                                @endif
                                <td>{{ $urun->price }}</td>
                                <td>{{ $urun->stock }}</td>
                                <td><a href="{{ route('show_image_upload', ['slug' => $urun->slug]) }}" class="btn btn-primary btn-sm btn-custom">Resim</a></td>
                                <td><a href="{{ route('show.edit_urun', ['slug' => $urun->slug]) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a></td>
                                <td><a href="{{ route('urun_sil', $urun->product_id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                </form>
            </div>
        </div>
    </div>
@endsection

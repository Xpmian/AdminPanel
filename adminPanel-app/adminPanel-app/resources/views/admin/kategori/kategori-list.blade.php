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
                                <td><a href="{{ route('categories.edit.form', $category->slug) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-custom" onclick="openModal({{ $category->id }})">Sil</button>
                                    <div id="myModal-{{ $category->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal({{ $category->id }})">&times;</span>
                                            <p>Bu kullanıcıyı silmek istediğinizden emin misiniz?</p>
                                            <button class="btn btn-secondary mt-2" onclick="closeModal({{ $category->id }})">İptal</button>
                                            <a  href="{{ route('categories.delete',$category->id) }}" class="btn btn-danger mt-2">Sil</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </form>

            </div>
        </div>
    </div>
@endsection
@section('js')
<script>
    function openModal(userId) {
            document.getElementById("myModal-" + userId).style.display = "block";
        }

        function closeModal(userId) {
            document.getElementById("myModal-" + userId).style.display = "none";
        }
</script>
@endsection

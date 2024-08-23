@extends('layouts.admin')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
@endsection

@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success text-succes" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="containerTotal">
            <div class="containerUpProductDelete">
                <div class="item-th"><input type="checkbox" id="select-all"> Hepsini Seç</div>
                <div class="item-th">Ürün Adı</div>
                <div class="item-th">Ürün Kategori</div>
                <div class="item-th">Ürün Barkodu</div>
                <div class="item-th">Ürün Durumu</div>
                <div class="item-th">Ürün Fiyat</div>
                <div class="item-th">Ürün Stok</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">
                <form action="{{ route('products.delete.list') }}" method="POST" id="softdelete-form">
                    @csrf
                    @method('DELETE')
                    <table class="formtable">
                        @foreach ($products as $product)
                            <tr class="trCompanyProductDelete">
                                <td><input type="checkbox" name="user_ids[]" value="{{ $product->product_id }}"></td>
                                <td>{{ $product->productTitle }}</td>
                                <td>{{ $product->categoryTitle }}</td>
                                <td>{{ $product->barcode }}</td>
                                @if ($product->productStatus == 1)
                                    <td style="color: green; font-weight: bold;">Aktif</td>
                                @elseif ($product->productStatus == 0)
                                    <td style="color: red; font-weight: bold;">Pasif</td>
                                @endif
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->stock }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-custom" onclick="openModal({{ $product->product_id }})">Sil</button>
                                    <div id="myModal-{{ $product->product_id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal({{ $product->product_id }})">&times;</span>
                                            <p>Bu kullanıcıyı silmek istediğinizden emin misiniz?</p>
                                            <button class="btn btn-secondary mt-2" onclick="closeModal({{ $product->product_id }})">İptal</button>
                                            <a href="{{ route('products.delete', $product->product_id) }}" class="btn btn-danger mt-2">Sil</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>

                    <button type="button" id="btnselectedDelete" class="btn btn-danger btn-sm btn-custom" onclick="openConfirmModal()">Seçilenleri Sil</button>
                    <div id="confirmModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeConfirmModal()">&times;</span>
                            <p>Seçilen ürünleri silmek istediğinizden emin misiniz?</p>
                            <button class="btn btn-secondary mt-2" onclick="closeConfirmModal()">İptal</button>
                            <button class="btn btn-danger mt-2" onclick="document.getElementById('softdelete-form').submit();">Sil</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
<script>
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('input[name="user_ids[]"]').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });

    function openModal(userId) {
        document.getElementById("myModal-" + userId).style.display = "block";
    }

    function closeModal(userId) {
        document.getElementById("myModal-" + userId).style.display = "none";
    }

    function openConfirmModal() {
        document.getElementById("confirmModal").style.display = "block";
    }

    function closeConfirmModal() {
        document.getElementById("confirmModal").style.display = "none";
    }
</script>
@endsection

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
                <form action="{{ route('products.delete.selected') }}" method="POST" id="softdelete-form">
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
                                <td><a href="{{ route('products.delete', $product->product_id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                    <button type="submit" id="btnselectedDelete" class="btn btn-danger btn-sm btn-custom">Seçilenleri Sil</button>
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
</script>
<script>
    // Hepsini Seç Checkbox
    document.getElementById('select-all').addEventListener('change', function() {
        const isChecked = this.checked;
        document.querySelectorAll('input[name="user_ids[]"]').forEach(checkbox => {
            checkbox.checked = isChecked;
        });
    });
</script>
@endsection


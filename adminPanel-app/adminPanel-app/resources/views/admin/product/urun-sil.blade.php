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
            <div class="containerUpProduct">
                <div class="item-th">Ürün Adı</div>
                <div class="item-th">Ürün Kategori ID</div>
                <div class="item-th">Ürün Barkodu</div>
                <div class="item-th">Ürün Durumu</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">
                <form action="{{ route('delete_product_select') }}" method="POST" id="softdelete-form">
                    @csrf
                    @method('DELETE')
                    <table>
                        @foreach ($urunler as $urun)
                            <tr class="trCompanyProduct">
                                <td><input type="checkbox" name="user_ids[]" value="{{ $urun->id }}"></td>
                                <td>{{ $urun->productTitle }}</td>
                                <td>{{ $urun->productCategoryId }}</td>
                                <td>{{ $urun->barcode }}</td>
                                @if ($urun->productStatus == 1)
                                    <td>Aktif</td>
                                @elseif ($urun->productStatus == 0)
                                    <td>Pasif</td>
                                @endif
                                <td><a href="{{ route('urun_sil', $urun->id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                            </tr>
                        @endforeach
                    </table>
                    <button type="submit" class="btn btn-danger btn-sm btn-custom">Seçilenleri Sil</button>
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
@endsection


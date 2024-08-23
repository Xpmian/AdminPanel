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
            <div class="containerUpKategori">
                <div class="item-th"><input type="checkbox" id="select-all"> Hepsini Seç</div>
                <div class="item-th">Kategori Adı</div>
                <div class="item-th">Kategori Açıklaması</div>
                <div class="item-th">Durum</div>
                <div class="item-th">Sil</div>
            </div>

            <div class="containerTable" style="overflow-x:auto;">
                <form action="{{ route('delete_category_select') }}" method="POST" id="softdelete-form">
                    @csrf
                    @method('DELETE')
                    <table >
                        @foreach ($kategoriler as $kategori)
                            <tr class="trCompanyKategori">
                                <td><input type="checkbox" name="user_ids[]" value="{{ $kategori->id }}"></td>
                                <td>{{ $kategori->categoryTitle }}</td>
                                <td>{{ $kategori->categoryDescription }}</td>
                                @if ($kategori->status == 1)
                                    <td style="color: green; font-weight: bold;">Aktif</td>
                                @elseif ($kategori->status == 0)
                                    <td style="color: red; font-weight: bold;">Pasif</td>
                                @endif
                                <td><a href="#" class="btn btn-danger btn-sm btn-custom">Sil</a></td>

                            </tr>
                        @endforeach
                    </table>
                    <button type="submit" id="btnselectedDelete"  class="btn btn-danger btn-sm btn-custom">Seçilenleri Sil</button>
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

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
                <form action="{{ route('categories.delete.selected') }}" method="POST" id="softdelete-form">
                    @csrf
                    @method('DELETE')
                    <table>
                        @foreach ($categories as $category)
                            <tr class="trCompanyKategori">
                                <td><input type="checkbox" name="user_ids[]" value="{{ $category->id }}"></td>
                                <td>{{ $category->categoryTitle }}</td>
                                <td>{{ $category->categoryDescription }}</td>
                                @if ($category->status == 1)
                                    <td style="color: green; font-weight: bold;">Aktif</td>
                                @elseif ($category->status == 0)
                                    <td style="color: red; font-weight: bold;">Pasif</td>
                                @endif
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-custom" onclick="openModal({{ $category->id }})">Sil</button>
                                    <div id="myModal-{{ $category->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal({{ $category->id }})">&times;</span>
                                            <p>Bu kategoriyi silmek istediğinizden emin misiniz?</p>
                                            <button class="btn btn-secondary mt-2" onclick="closeModal({{ $category->id }})">İptal</button>
                                            <a href="{{ route('categories.delete', $category->id) }}" class="btn btn-danger mt-2">Sil</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <button type="button" id="btnselectedDelete" class="btn btn-danger btn-sm btn-custom" onclick="openBulkDeleteModal()">Seçilenleri Sil</button>
                </form>

                <!-- Toplu Silme İçin Modal -->
                <div id="bulkDeleteModal" class="modal">
                    <div class="modal-content">
                        <span class="close" onclick="closeBulkDeleteModal()">&times;</span>
                        <p>Seçilen tüm kategorileri silmek istediğinizden emin misiniz?</p>
                        <button class="btn btn-secondary mt-2" onclick="closeBulkDeleteModal()">İptal</button>
                        <button type="button" class="btn btn-danger mt-2" onclick="document.getElementById('softdelete-form').submit();">Sil</button>
                    </div>
                </div>
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

    function openModal(categoryId) {
        document.getElementById("myModal-" + categoryId).style.display = "block";
    }

    function closeModal(categoryId) {
        document.getElementById("myModal-" + categoryId).style.display = "none";
    }

    function openBulkDeleteModal() {
        document.getElementById("bulkDeleteModal").style.display = "block";
    }

    function closeBulkDeleteModal() {
        document.getElementById("bulkDeleteModal").style.display = "none";
    }
</script>
@endsection

@extends('layouts.admin')

@section('css')
@endsection

@section('content')
    <div class="container mt-4">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h2 class="mb-4">Kullanıcı Sil</h2>

        <form action="{{ route('kategori_delete_list_show') }}" method="POST" id="softdelete-form">
            @csrf
            @method('DELETE')
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Kategori Adı</th>
                        <th>Kategori Açıklaması</th>
                        <th>Durum</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kategoriler  as $kategori)
                        <tr>
                            <td><input type="checkbox" name="user_ids[]" value="{{ $kategori->id }}"></td>
                            <td>{{ $kategori->categoryTitle }}</td>
                            <td>{{ $kategori->categoryDescription }}</td>
                            <td>{{ $kategori->status }}</td>

                            <td><a href="{{ route('kategori_sil', $kategori->id) }}" class="btn btn-danger btn-sm">Sil</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    </div>

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
@endsection

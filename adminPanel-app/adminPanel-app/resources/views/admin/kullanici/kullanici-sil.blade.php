@extends('layouts.admin')

@section('css')
@endsection

@section('content')
    <div class="row">
        @if(session('success'))
            <div class="alert alert-success text-succes" id="success-alert">
                {{ session('success') }}
            </div>
        @endif
        <div class="containerTotal">
            <div class="containerUpKullanici">
                <div class="item-th"><input type="checkbox" id="select-all"> Hepsini Seç</div>           
                <div class="item-th">Kullanıcı Adı</div>
                <div class="item-th">Kullanıcı Title</div>
                <div class="item-th">Sil</div>
            </div>
            <div class="containerTable" style="overflow-x:auto;">
            <form action="{{ route('delete_user_select') }}" method="POST" id="softdelete-form">
                @csrf
                @method('DELETE')
                <table class="formtable">
                    @foreach($users as $user)
                        <tr class="trCompanyKullanici">
                            <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->userTitle }}</td>
                            <td><a href="{{ route('kullanici_sil', $user->id) }}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
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

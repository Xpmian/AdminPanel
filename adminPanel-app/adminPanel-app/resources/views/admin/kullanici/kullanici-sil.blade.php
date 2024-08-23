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
                <form action="{{ route('users.delete.selected') }}" method="POST" id="softdelete-form">
                    @csrf
                    @method('DELETE')
                    <table class="formtable">
                        @foreach($users as $user)
                            <tr class="trCompanyKullanici">
                                <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                                <td>{{ $user->username }}</td>
                                <td>{{ $user->userTitle }}</td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm btn-custom" onclick="openModal({{ $user->id }})">Sil</button>
                                    <div id="myModal-{{ $user->id }}" class="modal">
                                        <div class="modal-content">
                                            <span class="close" onclick="closeModal({{ $user->id }})">&times;</span>
                                            <p>Bu kullanıcıyı silmek istediğinizden emin misiniz?</p>
                                            <button class="btn btn-secondary mt-2" onclick="closeModal({{ $user->id }})">İptal</button>
                                            <a href="{{ route('users.delete', $user->id) }}" class="btn btn-danger mt-2">Sil</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <!-- Popup Modal for Selected Delete -->
                    <button type="button" id="btnselectedDelete" class="btn btn-danger btn-sm btn-custom" onclick="openConfirmModal()">Seçilenleri Sil</button>
                    <div id="confirmModal" class="modal">
                        <div class="modal-content">
                            <span class="close" onclick="closeConfirmModal()">&times;</span>
                            <p>Seçilen kullanıcıları silmek istediğinizden emin misiniz?</p>
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

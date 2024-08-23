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

                <div class="containerUpKullanici">
                    <div class="item-th">Kullanıcı Adı</div>
                    <div class="item-th">Kullanıcı Title</div>
                    <div class="item-th">Düzenle</div>
                    <div class="item-th">Sil</div>
                </div>

                <div class="containerTable " style="overflow-x:auto;">
                    <form>
                        @csrf
                        <table class="formtable">
                            @foreach($users as $user)
                                <tr class="trCompanyKullanici">
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->userTitle }}</td>
                                    <td><a href="{{ route('users.edit.form', $user->slug) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
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
                    </form>
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

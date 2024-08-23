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

                <div class="containerUpKullanici">
                    <div class="item-th">Kullanıcı Adı</div>
                    <div class="item-th">Kullanıcı Title</div>
                    <div class="item-th">Düzenle</div>
                    <div class="item-th">Sil</div>
                </div>

                <div class="containerTable" style="overflow-x:auto;">
                    <form id="softdelete-form">
                        @csrf
                        <table>
                            @foreach($users as $user)
                                <tr class="trCompanyKullanici">
                                    <td>{{ $user->username }}</td>
                                    <td>{{ $user->userTitle }}</td>
                                    <td><a href="{{ route('show.edit', $user->id) }}" class="btn btn-warning btn-sm btn-custom">Düzenle</a>
                                    <td><a href="{{route('kullanici_sil', $user->id)}}" class="btn btn-danger btn-sm btn-custom">Sil</a></td>
                                </tr>
                            @endforeach
                        </table>
                    </form>
                </div>
            </div>
        </div>
    @endsection

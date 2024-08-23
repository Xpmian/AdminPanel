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

        <form action="{{ route('kullanici_sil_list') }}" method="POST" id="softdelete-form">
            @csrf
            @method('DELETE')


            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Kullanıcı Adı</th>
                        <th>Kullanıcı Title</th>
                        <th>Sil</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td><input type="checkbox" name="user_ids[]" value="{{ $user->id }}"></td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->userTitle }}</td>
                            <td><a href="{{ route('kullanici_sil', $user->id) }}" class="btn btn-danger btn-sm">Sil</a></td>
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

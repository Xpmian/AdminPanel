<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title >Admin Paneli</title>
    <link rel="stylesheet" href="~/lib/bootstrap/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
    @yield('css')
</head>
<body>

    <header style="background-color: #284b63">
        <nav class="navbar navbar-expand-sm navbar-toggleable-sm  border-bottom box-shadow mb-3">
            <div>
                <a class="navbar-brand"style="color: white; align-self: center; margin-left: 20px; font-weight: 700; font-size: 2rem;">ADMİN PANELİ</a>
            </div>
        </nav>
    </header>

    <div class="row paneller" style="margin:20px">
        <div class="col-2">
                <div class="profile-panel">
                    <div class="list-group " style="display: flex; justify-content: center; align-items: center;">
                        <a href="{{ route('users.edit.form', session('slug')) }}">
                            <img src="{{ asset('img/account.png') }}" id="profileImage" alt="Logo" style="width:70%; margin-left:30px;">
                        </a>
                        @if(session('userTitle'))
                            <p class="mt-1" style="font-weight: bold; font-size: 1.25rem;">
                                {{ session('userTitle') }}
                            </p>
                        @endif
                        <p></p>
                            <ul style="margin-top: 0.75%;">
                                <li class="list-group-item dropdown">
                                    <button class="dropbtn" style="border: none;">
                                        <i class="fa-solid fa-user me-1 "></i>Admin Kullanıcı Yönetimi
                                        <div class="dropdown-content">
                                            <a style="text-decoration:none;color:black" href="{{route('users.list')}}">
                                                Kullanıcı Listeleme Sayfası
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('users.create.form')}}">
                                                Kullanıcı Ekleme Formu
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('users.delete.list')}}">
                                                Kullanıcı Silme Formu
                                            </a>
                                        </div>
                                    </button>

                                </li>

                                <li class="list-group-item dropdown">
                                    <button class="dropbtn" style="border: none;">
                                        <i class="fa-solid fa-list me-1"></i>Kategori Yönetimi
                                        <div class="dropdown-content">
                                            <a style="text-decoration:none;color:black" href="{{route('categories.list')}}">
                                                Kategori listeme formu
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('categories.create.form')}}">
                                                Kategori ekleme formu
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('categories.delete.list')}}">
                                                Kategori silme
                                            </a>
                                        </div>
                                    </button>
                                </li>

                                <li class="list-group-item dropdown">
                                    <button class="dropbtn" style="border: none;">
                                        <i class="fa-brands fa-dropbox me-1"></i>Ürün Yönetimi
                                        <div class="dropdown-content">
                                            <a style="text-decoration:none;color:black" href="{{route('products.list')}}">
                                                Ürün listeleme sayfası
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('products.create.form')}}">
                                                Ürün ekleme formu
                                            </a>
                                            <a style="text-decoration:none;color:black" href="{{route('products.delete.list')}}">
                                                Ürün silme
                                            </a>
                                        </div>
                                    </button>

                                </li>
                            </ul>
                            <form action="{{ route('login.off') }}" method="POST">
                                @csrf
                                <button type="submit" id="btnLogoff" style="color: white; float: right; width: 60%; padding: 5px; display: block; margin: 0 auto; background-color: #284b63; border: none; border-radius: 5px; position: absolute; bottom: 3%; text-decoration: none; align-self: center;   ">
                                    <i class="fa-solid fa-arrow-right-from-bracket me-3"></i>Çıkış Yap
                                </button>
                            </form>
                    </div>
                </div>

        </div>

        <div class="col-lg-10 col-xs-12 col-md-12">
            <div class="panel-right" style="position:relative;">
                <div>
                    <div class="content">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"
    integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS"
    crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
    crossorigin="anonymous"></script>

    @yield('js')
<script>

    let alerts = document.getElementsByClassName('alert');

    setTimeout(function() {
        for(let i = 0; i < alerts.length; i++) {
            alerts[i].style.display = 'none';
        }
    }, 1500);


</script>

</body>
</html>

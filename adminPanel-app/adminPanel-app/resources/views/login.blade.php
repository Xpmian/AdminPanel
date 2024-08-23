<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Document</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }
        body {
            background-color: #d9d9d9;
        }
        #loginTitle {
            font-size: 2rem;
            text-align: center;
            font-weight: bold;
            color: white;
        }
        #loginDiv {
            border-radius: 10px;
            min-height: 400px;
            padding: 1.5rem;
            background: #284b63;
        }
        .formGroup {
            text-align: center;
            padding: 0.5rem 2rem;
            margin: 0.5rem;
        }
        .formGroup label {
            display: block;
            text-align: left;
            font-size: 1.2rem;
            font-weight: 600;
        }
        .formGroup input {
            width: 100%;
            padding: 0.5rem;
            border: none;
            border-radius: 5px;
        }
        .btnForm {
            border: none;
            border-radius: 5px;
            padding: 0.8rem 1rem;
            margin: 0.5rem;
            background-color: #CCCCCC;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container" style="height: 100vh;">
        <div class="row justify-content-around align-items-center" style="height: 100%;">
            <div class="col-xs-12 col-lg-6" id="loginDiv">
                <h2 id="loginTitle">LOGIN</h2>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first('login_error') }}
                    </div>
                @endif

                <form action="{{ route('aut.login') }}" method="POST">
                    @csrf
                    <div class="formGroup">
                        <label for="uname">Kullanıcı Adı:</label>
                        <input type="text" placeholder="Kullanıcı adını giriniz!" name="name" required>
                    </div>

                    <div class="formGroup">
                        <label for="psw">Şifre:</label>
                        <input type="password" placeholder="Şifreyi giriniz!" name="psw" required>
                    </div>

                    <div class="formGroup">
                        <button type="submit" class="btnForm" id="btnLogin">GİRİŞ YAP</button>
                        {{-- <button type="submit" class="btnForm" id="btnReg">KAYIT OL</button> --}}
                    </div>
                </form>
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
</body>
</html>

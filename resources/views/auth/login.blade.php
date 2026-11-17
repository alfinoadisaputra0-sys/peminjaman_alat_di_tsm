<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Peminjaman Alat TSM</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #eeeeee;
            margin: 0;
            padding: 40px 15px;
        }

        .container {
            max-width: 380px;
            margin: auto;
            padding: 25px;
            background: white;
            border: 1px solid #cccccc;
            border-radius: 8px;
        }

        h2 {
            text-align: center;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input {
            box-sizing: border-box;
            width: 100%;
            padding: 10px;
            margin-top: 5px;
        }

        button {
            width: 100%;
            padding: 11px;
            margin-top: 20px;
            background: #1769aa;
            color: white;
            border: none;
            cursor: pointer;
        }

        .error {
            color: red;
            font-size: 14px;
        }

        .success {
            color: green;
        }

        .link {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Login Peminjaman Alat TSM</h2>

    @if (session('success'))
        <p class="success">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <div class="error">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('login.process') }}" method="POST">
        @csrf

        <label>Email</label>
        <input type="email" name="email"
               value="{{ old('email') }}" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <div class="link">
        Belum punya akun?
        <a href="{{ route('register') }}">Daftar sekarang</a>
    </div>
</div>

</body>
</html>
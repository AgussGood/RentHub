<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RentHub - Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            width: 100%;
            max-width: 900px;
            display: flex;
            min-height: 550px;
        }

        .left-panel {
            flex: 1;
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
        }

        .logo span {
            color: #00ff88;
        }

        .left-panel h2 {
            font-size: 28px;
            margin-bottom: 20px;
        }

        .left-panel p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
        }

        .car-icon {
            font-size: 80px;
            margin-top: 40px;
        }

        .right-panel {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            color: #721c24;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            margin-bottom: 8px;
            display: block;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 2px solid #ddd;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: #0066ff;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
        }

        .switch-form {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password {
            text-align: right;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <!-- LEFT -->
    <div class="left-panel">
        <div class="logo">Rent<span>Hub</span></div>
        <h2>Selamat Datang Kembali!</h2>
        <p>
            Masuk untuk mengakses akun Anda dan lanjutkan perjalanan bersama RentHub.
            Penyewaan kendaraan cepat, mudah, dan aman.
        </p>
        <div class="car-icon">🚗</div>
    </div>

    <!-- RIGHT -->
    <div class="right-panel">
        <h3>Masuk</h3>
        <p class="subtitle">Silakan login ke akun Anda</p>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    {{ $error }}<br>
                @endforeach
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf

            <div class="input-group">
                <label>Email</label>
                <input type="email" name="email" placeholder="Masukkan email Anda" required>
            </div>

            <div class="input-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Masukkan password Anda" required>
            </div>

            <div class="forgot-password">
                <a href="#">Lupa password?</a>
            </div>

            <button class="btn">Masuk</button>
        </form>

        <div class="switch-form">
            Belum punya akun?
            <a href="{{ route('register') }}">Daftar di sini</a>
        </div>
    </div>

</div>

</body>
</html>
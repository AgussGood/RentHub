<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CARBOOK - Login</title>
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

        .left-panel::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 15s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .logo {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 30px;
            z-index: 1;
        }

        .logo span {
            color: #00ff88;
        }

        .left-panel h2 {
            font-size: 28px;
            margin-bottom: 20px;
            z-index: 1;
        }

        .left-panel p {
            font-size: 16px;
            line-height: 1.6;
            opacity: 0.9;
            z-index: 1;
        }

        .car-icon {
            font-size: 80px;
            margin-top: 40px;
            z-index: 1;
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
            border: 1px solid #c3e6cb;
            color: #155724;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .input-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
            font-weight: 500;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 14px;
            transition: all 0.3s;
        }

        input:focus {
            outline: none;
            border-color: #0066ff;
            box-shadow: 0 0 0 3px rgba(0, 102, 255, 0.1);
        }

        input.error {
            border-color: #ff4444;
        }

        .error-message {
            color: #ff4444;
            font-size: 12px;
            margin-top: 5px;
        }

        .btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #0066ff 0%, #0052cc 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 102, 255, 0.3);
        }

        .btn:active {
            transform: translateY(0);
        }

        .switch-form {
            text-align: center;
            margin-top: 20px;
            color: #666;
            font-size: 14px;
        }

        .switch-form a {
            color: #0066ff;
            text-decoration: none;
            font-weight: 600;
        }

        .switch-form a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            text-align: right;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .forgot-password a {
            color: #0066ff;
            text-decoration: none;
            font-size: 13px;
        }

        .forgot-password a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-panel {
                padding: 40px 30px;
                text-align: center;
            }

            .right-panel {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">Rent<span>Hub</span></div>
            <h2>Welcome Back!</h2>
            <p>Login to access your account and continue your journey with CARBOOK. Fast, easy, and secure car rental service at your fingertips.</p>
            <div class="car-icon">🚗</div>
        </div>

        <div class="right-panel">
            <h3>Login</h3>
            <p class="subtitle">Please login to your account</p>

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
                    <label for="login-email">Email Address</label>
                    <input type="email" id="login-email" name="email" placeholder="Enter your email" 
                           value="{{ old('email') }}" required class="@error('email') error @enderror">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="login-password">Password</label>
                    <input type="password" id="login-password" name="password" 
                           placeholder="Enter your password" required class="@error('password') error @enderror">
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">Login</button>
            </form>

            <div class="switch-form">
                Don't have an account? <a href="{{ route('register') }}">Register here</a>
            </div>
        </div>
    </div>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CARBOOK - Register</title>
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

        .features {
            margin-top: 30px;
            z-index: 1;
        }

        .feature-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 14px;
        }

        .feature-item::before {
            content: '✓';
            display: inline-block;
            width: 24px;
            height: 24px;
            background: rgba(0, 255, 136, 0.2);
            border-radius: 50%;
            text-align: center;
            line-height: 24px;
            margin-right: 12px;
            color: #00ff88;
            font-weight: bold;
        }

        .car-icon {
            font-size: 60px;
            margin-top: 20px;
            z-index: 1;
        }

        .right-panel {
            flex: 1;
            padding: 60px 40px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: auto;
        }

        h3 {
            font-size: 28px;
            color: #333;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .alert {
            padding: 12px 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-error {
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
        }

        .input-group {
            margin-bottom: 18px;
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

        .password-strength {
            margin-top: 5px;
            font-size: 12px;
            color: #999;
        }

        .strength-bar {
            height: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            margin-top: 5px;
            overflow: hidden;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            background: #ccc;
            transition: all 0.3s;
        }

        .strength-weak { background: #ff4444; width: 33%; }
        .strength-medium { background: #ffaa00; width: 66%; }
        .strength-strong { background: #00cc44; width: 100%; }

        .checkbox-group {
            display: flex;
            align-items: flex-start;
            margin: 15px 0;
        }

        .checkbox-group input[type="checkbox"] {
            width: auto;
            margin-right: 8px;
            margin-top: 3px;
        }

        .checkbox-group label {
            margin-bottom: 0;
            font-size: 13px;
            line-height: 1.5;
        }

        .checkbox-group a {
            color: #0066ff;
            text-decoration: none;
        }

        .checkbox-group a:hover {
            text-decoration: underline;
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
            margin-top: 5px;
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

            .feature-item {
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-panel">
            <div class="logo">CAR<span>BOOK</span></div>
            <h2>Join CARBOOK Today!</h2>
            <p>Create your account and unlock access to thousands of premium cars with the best rental experience.</p>
            
            <div class="features">
                <div class="feature-item">Wide selection of vehicles</div>
                <div class="feature-item">Competitive pricing</div>
                <div class="feature-item">24/7 customer support</div>
                <div class="feature-item">Flexible rental periods</div>
                <div class="feature-item">Easy booking process</div>
            </div>
            
            <div class="car-icon">🚙</div>
        </div>

        <div class="right-panel">
            <h3>Create Account</h3>
            <p class="subtitle">Sign up to get started with CARBOOK</p>

            @if($errors->any())
                <div class="alert alert-error">
                    @foreach($errors->all() as $error)
                        {{ $error }}<br>
                    @endforeach
                </div>
            @endif
            
            <form action="{{ route('register') }}" method="POST" id="registerForm">
                @csrf
                <div class="input-group">
                    <label for="register-name">Full Name</label>
                    <input type="text" id="register-name" name="name" placeholder="Enter your full name" 
                           value="{{ old('name') }}" required class="@error('name') error @enderror">
                    @error('name')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="register-email">Email Address</label>
                    <input type="email" id="register-email" name="email" placeholder="Enter your email" 
                           value="{{ old('email') }}" required class="@error('email') error @enderror">
                    @error('email')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="register-phone">Phone Number</label>
                    <input type="tel" id="register-phone" name="phone" placeholder="Enter your phone number" 
                           value="{{ old('phone') }}" required class="@error('phone') error @enderror">
                    @error('phone')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="register-password">Password</label>
                    <input type="password" id="register-password" name="password" 
                           placeholder="Create a password (min. 8 characters)" 
                           required minlength="8" oninput="checkPasswordStrength()" 
                           class="@error('password') error @enderror">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strength-fill"></div>
                    </div>
                    <div class="password-strength" id="password-strength">Password strength: <span id="strength-text">-</span></div>
                    @error('password')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="input-group">
                    <label for="register-confirm">Confirm Password</label>
                    <input type="password" id="register-confirm" name="password_confirmation" 
                           placeholder="Confirm your password" required class="@error('password_confirmation') error @enderror">
                    @error('password_confirmation')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>

                <div class="checkbox-group">
                    <input type="checkbox" id="terms" required>
                    <label for="terms">I agree to the <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a></label>
                </div>

                <button type="submit" class="btn">Create Account</button>
            </form>

            <div class="switch-form">
                Already have an account? <a href="{{ route('login') }}">Login here</a>
            </div>
        </div>
    </div>

    <script>
        function checkPasswordStrength() {
            const password = document.getElementById('register-password').value;
            const strengthFill = document.getElementById('strength-fill');
            const strengthText = document.getElementById('strength-text');
            
            let strength = 0;
            
            if (password.length >= 8) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;
            
            strengthFill.className = 'strength-fill';
            
            if (strength <= 1) {
                strengthFill.classList.add('strength-weak');
                strengthText.textContent = 'Weak';
                strengthText.style.color = '#ff4444';
            } else if (strength <= 3) {
                strengthFill.classList.add('strength-medium');
                strengthText.textContent = 'Medium';
                strengthText.style.color = '#ffaa00';
            } else {
                strengthFill.classList.add('strength-strong');
                strengthText.textContent = 'Strong';
                strengthText.style.color = '#00cc44';
            }
        }
    </script>
</body>
</html>
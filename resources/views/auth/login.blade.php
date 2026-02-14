<!DOCTYPE html>
<html>
<head>
    <title>Login</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #F2EDED;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* WRAPPER */
        .login-wrapper {
            width: 900px;
            height: 500px;
            display: flex;
            background: white;
            box-shadow: 0 15px 40px rgba(0,0,0,.15);
        }

        /* LEFT SIDE (GAMBAR) */
        .login-left {
            flex: 1;
            background: #d9d9d9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-left img {
            max-width: 100%;
            height: 500px;
        }

        /* RIGHT SIDE (FORM) */
        .login-right {
            flex: 1;
            background: #FFFFFF;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 60px;
        }

        .logo-text {
            font-size: 40px;
            text-align: center;
            margin-bottom: 10px;
        }

        .login-title {
            text-align: center;
            margin: 30px 40px 30px 60px;
            
            letter-spacing: 2px;
            color: #1a252f;
        }

        .input-group {
            position: relative;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 12px;
            border: none;
            outline: none;
            background: #ddd;
            text-align: center;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 14px;
            color: #333;
            background: none;
            border: none;
        }

        button  {
            padding: 12px;
            border: none;
            background: #2c3e50;
            color: white;
            cursor: pointer;
            margin: auto;
        }

        .button {
            margin-left: 180px;
        }

        .button:hover {
            background: #1a252f;
            width: 10px;

            
        }

        .error {
            margin-top: 15px;
            text-align: center;
            color: #ffdddd;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- DIV 1 : GAMBAR -->
    <div class="login-left">
        {{-- KOLOM UNTUK GAMBAR --}}
        <img src="{{ asset('storage/Images/IMG.png') }}" style="display: block; margin: 0 auto; width:100%; 	hight:100%;" alt="Login Image">
    </div>

    <!-- DIV 2 : FORM -->
    <div class="login-right">

        <img src="{{ asset('storage/Images/Logo.jpg') }}" style="display: block; margin: 50px 60px 50px 100px ; width:200px; hight:150px;" alt="Login Image">
       
        <div class="login-title">LOGIN</div>

        <form method="POST" action="{{ route('login.store') }}">
            @csrf

            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="password" name="password" id="password" placeholder="Password" required>
                <div class="dd">
                <button type="button" class="toggle-password" onclick="togglePassword()">
                    Show
                </button>
            </div>
            
        </div>
            <div class="button">
            <button type="submit">Login</button>
        </div>
        </form>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

    </div>

</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        const toggleBtn = document.querySelector('.toggle-password');

        if (password.type === "password") {
            password.type = "text";
            toggleBtn.innerText = "Hide";
        } else {
            password.type = "password";
            toggleBtn.innerText = "Show";
        }
    }
</script>

</body>
</html>

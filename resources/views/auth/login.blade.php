<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body {
            background: #f3f4f6;
            font-family: Arial, sans-serif;
        }

        .box {
            width: 350px;
            margin: 120px auto;
            background: white;
            padding: 24px;
            border-radius: 8px;
            box-shadow: 0 10px 25px rgba(0,0,0,.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .input-group {
            position: relative;
            margin-top: 12px;
        }

        input {
            width: 100%;
            padding: 10px 40px 10px 10px;
            box-sizing: border-box;
            text-align: center;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 18px;
            color: #555;
        }

        button {
            width: 100%;
            padding: 10px;
            margin-top: 16px;
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background: #1e40af;
        }

        .error {
            color: red;
            margin-top: 10px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="box">
    <h2>Login</h2>

    <form method="POST" action="{{ route('login.store') }}">
        @csrf

        <div class="input-group">
            <input type="text" name="username" placeholder="Username" required>
        </div>

        <div class="input-group">
            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="toggle-password" onclick="togglePassword()">👁</span>
        </div>

        <button type="submit">Login</button>
    </form>

    @if(session('error'))
        <div class="error">{{ session('error') }}</div>
    @endif
</div>

<script>
    function togglePassword() {
        const password = document.getElementById('password');
        if (password.type === "password") {
            password.type = "text";
        } else {
            password.type = "password";
        }
    }
</script>

</body>
</html>

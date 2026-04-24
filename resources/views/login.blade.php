<!DOCTYPE html>
<html>
<head>
    <title>Buku Kas</title>
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            flex-direction: column; /* biar judul di atas */
            justify-content: center;
            align-items: center;

            background: url('images/bendahara.jpg') no-repeat center center/cover;
            position: relative;
        }

        /* OVERLAY */
        body::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            top: 0;
            left: 0;
        }

        /* JUDUL ATAS */
        .title {
            position: relative;
            color: white;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
            text-align: center;
        }

        .login-box {
            position: relative;
            background: white;
            padding: 30px;
            border-radius: 15px;
            width: 320px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.3);
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #0ea5e9;
        }

        .login-box label {
            font-size: 14px;
            color: #555;
            font-weight: bold;
        }

        .login-box input {
            width: 93%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            outline: none;
        }

        .login-box input:focus {
            border-color: #0ea5e9;
        }

        .login-box button {
            width: 100%;
            padding: 10px;
            background: #0ea5e9;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .login-box button:hover {
            background: #0284c7;
        }

        .error {
            background: #fee2e2;
            color: #dc2626;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
        }

        .footer {
            text-align: center;
            margin-top: 10px;
            font-size: 12px;
            color: #888;
        }
    </style>
</head>
<body>

<div class="title">
    BUKU KAS
</div>

<div class="login-box">
    <h2>Login</h2>

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit">Login</button>
    </form>

    <div class="footer">
        Sistem Buku Kas
</div>

</body>
</html>
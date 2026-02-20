<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Es Teler Kyuu 88</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f28c8c;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            background: #f5e3a3;
            border-radius: 25px;
            display: flex;
            overflow: hidden;
            padding: 40px;
        }

        /* LEFT SIDE */
        .left {
            width: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .circle-bg {
            position: absolute;
            width: 450px;
            height: 450px;
            background: #b9db5a;
            border-radius: 50%;
        }

        .product-img {
            position: relative;
            width: 350px;
            z-index: 2;
        }

        /* RIGHT SIDE */
        .right {
            width: 50%;
            padding: 40px;
            text-align: center;
        }

        .logo {
            width: 200px;
            margin-bottom: 20px;
        }

        .right h2 {
            color: #0a8f08;
            margin-bottom: 20px;
        }

        form {
            width: 70%;
            margin: auto;
            text-align: left;
        }

        label {
            color: #0a8f08;
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }

        input {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            border: none;
            margin-top: 5px;
            background: #e9e9e9;
        }

        button {
            margin-top: 25px;
            width: 100%;
            padding: 10px;
            background: #f28c8c;
            border: none;
            border-radius: 8px;
            color: white;
            font-weight: bold;
            cursor: pointer;
        }

        button:hover {
            background: #e57474;
        }

        .error-box {
            background: #ffcccc;
            color: red;
            padding: 8px;
            border-radius: 6px;
            margin-bottom: 10px;
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                padding: 20px;
            }

            .left {
                display: none;
            }

            .right {
                width: 100%;
            }

            form {
                width: 100%;
            }
        }
    </style>

</head>
<body>

<div class="container">

    <!-- LEFT SIDE -->
    <div class="left">
        <div class="circle-bg"></div>
        <!-- GANTI dengan gambar kamu -->
        <img src="{{ asset('images/es_teler.png') }}" class="product-img">
    </div>

    <!-- RIGHT SIDE -->
    <div class="right">

        <!-- GANTI dengan logo kamu -->
        <img src="{{ asset('images/logo.png') }}" class="logo">

        <h2>LOGIN</h2>

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <label>Username :</label>
            <input type="text" name="username" required>

            <label>Password :</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>

    </div>

</div>

</body>
</html>

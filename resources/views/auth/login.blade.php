<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Es Teler Kyuu 88</title>

    <style>
        /* --- ANIMASI KEYFRAMES --- */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes zoomIn {
            from { opacity: 0; transform: scale(0.5); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes slideInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f28c8c;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Mencegah scroll saat animasi jalan */
        }

        .container {
            width: 90%;
            max-width: 1000px;
            background: #f5e3a3;
            border-radius: 40px;
            display: flex;
            overflow: hidden;
            padding: 40px;
            box-shadow: 0 20px 0 rgba(0,0,0,0.1);
            /* Penerapan Animasi */
            animation: fadeInUp 0.8s ease-out;
        }

        /* LEFT SIDE */
        .left {
            width: 50%;
            position: relative;
            display: flex;
            justify-content: center;
            align-items: center;
            /* Penerapan Animasi */
            animation: zoomIn 1s cubic-bezier(0.175, 0.885, 0.32, 1.275) 0.3s backwards;
        }

        .circle-bg {
            position: absolute;
            width: 400px;
            height: 400px;
            background: #b9db5a;
            border-radius: 50%;
            border: 10px solid rgba(255,255,255,0.2);
        }

        .product-img {
            position: relative;
            width: 380px;
            z-index: 2;
            filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
            transition: transform 0.3s ease;
        }

        .product-img:hover {
            transform: scale(1.05) rotate(5deg);
        }

        /* RIGHT SIDE */
        .right {
            width: 50%;
            padding: 20px 40px;
            text-align: center;
            display: flex;
            flex-direction: column;
            justify-content: center;
            /* Penerapan Animasi */
            animation: slideInRight 0.8s ease-out 0.5s backwards;
        }

        .logo {
            width: 180px;
            margin: 0 auto 20px auto;
            /* Efek melayang halus setelah muncul */
            animation: fadeInUp 0.6s ease-out 0.7s backwards, logoFloat 3s ease-in-out 1.3s infinite;
        }

        .right h2 {
            color: #0a8f08;
            font-size: 32px;
            font-weight: 900;
            margin-bottom: 25px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        form {
            width: 100%;
            max-width: 320px;
            margin: auto;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            color: #0a8f08;
            font-weight: 900;
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            text-transform: uppercase;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border-radius: 15px;
            border: 3px solid transparent;
            background: #ffffff;
            font-size: 16px;
            font-weight: bold;
            box-sizing: border-box;
            outline: none;
            transition: all 0.3s;
        }

        input:focus {
            border-color: #b9db5a;
            box-shadow: 0 0 10px rgba(185, 219, 90, 0.3);
        }

        button {
            margin-top: 20px;
            width: 100%;
            padding: 15px;
            background: #f28c8c;
            border: none;
            border-bottom: 5px solid #d46a6a;
            border-radius: 15px;
            color: white;
            font-size: 18px;
            font-weight: 900;
            cursor: pointer;
            text-transform: uppercase;
            transition: all 0.2s;
        }

        button:hover {
            background: #e57474;
            transform: translateY(-2px);
            border-bottom-width: 7px;
        }

        button:active {
            transform: translateY(2px);
            border-bottom-width: 2px;
        }

        .error-box {
            background: #ff4d4d;
            color: white;
            padding: 12px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-weight: bold;
            font-size: 13px;
            text-align: center;
            animation: zoomIn 0.4s ease-out; /* Animasi kecil saat error muncul */
        }

        /* RESPONSIVE */
        @media (max-width: 900px) {
            .container {
                flex-direction: column;
                padding: 30px;
                border-radius: 30px;
                height: auto;
            }
            .left { display: none; }
            .right { width: 100%; padding: 10px; }
            form { max-width: 100%; }
            body { overflow: auto; }
        }
    </style>
</head>
<body>

<div class="container">
    <div class="left">
        <div class="circle-bg"></div>
        <img src="{{ asset('images/es_teler.png') }}" alt="Es Teler Kyuu" class="product-img">
    </div>

    <div class="right">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">

        <h2>MASUK ADMIN</h2>

        @if (session('error'))
            <div class="error-box">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-box">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login.process') }}" method="POST">
            @csrf 
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Masukkan username..." required autofocus>
            </div>

            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="••••••••" required>
            </div>

            <button type="submit">LOGIN</button>
        </form>
    </div>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login | Es Teler Kyuu 88</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-blue-600 flex items-center justify-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-sm">

    <h1 class="text-2xl font-bold text-center mb-6">
        Login Admin
    </h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-600 p-2 rounded mb-4 text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="/login">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">
                Username
            </label>
            <input type="text" name="username"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">
                Password
            </label>
            <input type="password" name="password"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring focus:border-blue-400"
                required>
        </div>

        <button
            class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700 transition">
            Login
        </button>
    </form>

</div>

</body>
</html>

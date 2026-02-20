<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Es Teler Kyuu 88' }}</title>

    @vite('resources/css/app.css')

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #ffffff;
        }

        .layout-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 230px;
            background: #F4E5B5;
            padding: 30px 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .sidebar h1 {
            text-align: center;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .sidebar a,
        .sidebar button {
            background: #F08A8A;
            color: white;
            padding: 12px;
            text-align: center;
            border-radius: 10px;
            text-decoration: none;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        .sidebar a:hover,
        .sidebar button:hover {
            background: #e57474;
        }

        /* CONTENT */
        .main-content {
            flex: 1;
            padding: 40px;
            background: #A8C66C;
        }

    </style>
</head>
<body>

@if(request()->is('login'))
    <main>
        @yield('content')
    </main>
@else

<div class="layout-wrapper">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <h1>Es Teler<br>Kyuu 88</h1>

        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('produk.index') }}">Produk</a>
        <a href="{{ route('kasir.index') }}" class="block px-4 py-2 hover:bg-blue-700">Kasir</a>
        <a href="{{ route('transaksi.index') }}" class="sidebar-link">Transaksi</a>
        <a href="{{ route('laporan.index') }}">Laporan</a>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit">LogOut</button>
        </form>

    </aside>

    <!-- CONTENT -->
    <main class="main-content">
        @yield('content')
    </main>

</div>

@endif

</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Es Teler Kyuu 88' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #A3C572; /* Hijau Background Utama */
            min-height: 100vh;
        }
        
        /* Sidebar khusus sesuai warna pilihanmu */
        .sidebar {
            background-color: #F2E3B6; /* Krem Sidebar */
            min-height: 100vh;
            border-right: 4px solid rgba(0,0,0,0.05);
        }
        
        /* Navigasi Link gaya tombol pink */
        .nav-link {
            background-color: #F08A8A; /* Pink Tombol */
            color: white !important;
            transition: all 0.2s ease;
            box-shadow: 0 4px 0px #d67676;
        }

        .nav-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 0px #d67676;
            background-color: #f29797;
        }

        .nav-link.active {
            background-color: #e57373;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
            transform: translateY(2px);
        }

        .product-card {
            background-color: #F2E3B6;
            border-radius: 24px;
            transition: transform 0.2s;
        }

        .product-card:hover {
            transform: scale(1.02);
        }
    </style>
</head>
<body class="antialiased">
    <div class="flex flex-col md:flex-row min-h-screen">
        <aside class="sidebar w-full md:w-64 p-6 flex flex-col shadow-xl">
            <h1 class="text-3xl font-extrabold mb-10 text-center text-gray-800 leading-tight">
                Es Teler<br><span class="text-pink-500">Kyuu 88</span>
            </h1>
            
            <nav class="flex flex-col gap-4 flex-grow">
                <a href="{{ route('produk.index') }}" class="nav-link {{ Request::is('produk*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-box w-6"></i>
                    <span>Produk</span>
                </a>
                <a href="{{ route('kasir.index') }}" class="nav-link {{ Request::is('kasir*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-cash-register w-6"></i>
                    <span>Kasir</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="nav-link {{ Request::is('transaksi*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-exchange-alt w-6"></i>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link {{ Request::is('laporan*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="mt-10 border-t border-black/5 pt-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full bg-gray-200 text-gray-700 hover:bg-red-500 hover:text-white transition p-3 rounded-xl font-bold flex items-center justify-center space-x-2">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>LogOut</span>
                    </button>
                </form>
            </div>
        </aside>
        
        <main class="flex-1 p-6 md:p-12 overflow-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>
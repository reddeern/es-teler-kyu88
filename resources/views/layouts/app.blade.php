<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Es Teler Kyuu 88' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/es_teler.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #A3C572;
            min-height: 100vh;
        }
        
        .sidebar {
            background-color: #F2E3B6;
            min-height: 100vh;
            border-right: 4px solid rgba(0,0,0,0.05);
            z-index: 50;
        }
        
        /* --- KEYFRAMES --- */
        @keyframes slideInSidebar {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes popElement {
            from { transform: scale(0.8) translateY(20px); opacity: 0; }
            to { transform: scale(1) translateY(0); opacity: 1; }
        }

        /* --- CLASS ANIMASI --- */
        .animate-sidebar {
            animation: slideInSidebar 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        /* Class untuk elemen yang akan di-stagger (diperlambat satu-satu) */
        .stagger-item {
            opacity: 0; /* Default sembunyi dulu */
        }

        .animate-stagger {
            animation: popElement 0.5s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }

        /* Navigasi Link gaya tombol pink */
        .nav-link {
            background-color: #F08A8A;
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

        /* Update bagian ini di layouts.app */
.product-card {
    background-color: #F2E3B6 !important; /* Kita paksa warna Krem aslimu */
    border-radius: 24px;
    transition: transform 0.2s;
    /* Tambahin shadow dikit biar kepisah dari background ijo */
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1);
    border: 2px solid rgba(255, 255, 255, 0.5); /* Kasih border putih tipis biar makin tegas warnanya */
}

@media print {
    /* 1. Sembunyikan TOTAL semua UI web */
    body * {
        visibility: hidden;
    }

    /* 2. Hilangkan space sisa dari sidebar & main container */
    aside, #main-sidebar, .sidebar, .no-print {
        display: none !important;
        height: 0 !important;
    }

    /* 3. Tampilkan hanya area struk */
    .printer-wrapper, .printer-wrapper * {
        visibility: visible;
    }

    /* 4. Paksa posisi ke pojok kiri atas & hilangkan scroll */
    .printer-wrapper {
        position: absolute;
        left: 0;
        top: 0;
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    /* 5. Skala abang yang sudah pas 2.5x */
    .animate-receipt {
        transform: scale(2.5) !important;
        transform-origin: top left !important;
        width: 300px !important;
        animation: none !important;
    }

    /* 6. Matikan desain yang gak perlu di kertas */
    .receipt-body {
        box-shadow: none !important;
        border: none !important;
        padding: 0 !important; /* Biar nggak kepotong margin */
    }

    /* 7. KUNCI UTAMA: Hapus sisa halaman kosong */
    @page {
        margin: 0;
        size: auto;
    }

    html, body {
        height: auto !important;
        overflow: hidden !important; /* Biar nggak ada scroll yang bikin halaman 2 */
    }
}
    </style>
</head>
<body class="antialiased">
    <div class="flex flex-col md:flex-row min-h-screen">
        <aside id="main-sidebar" class="sidebar w-full md:w-64 p-6 flex flex-col shadow-xl">
            <h1 class="stagger-item text-3xl font-extrabold mb-10 text-center text-gray-800 leading-tight">
                Es Teler<br><span class="text-pink-500">Kyuu 88</span>
            </h1>
            
            <nav class="flex flex-col gap-4 flex-grow">
                <a href="{{ route('produk.index') }}" class="stagger-item nav-link {{ Request::is('produk*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-box w-6"></i>
                    <span>Produk</span>
                </a>
                <a href="{{ route('kasir.index') }}" class="stagger-item nav-link {{ Request::is('kasir*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-cash-register w-6"></i>
                    <span>Kasir</span>
                </a>
                <a href="{{ route('transaksi.index') }}" class="stagger-item nav-link {{ Request::is('transaksi*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-exchange-alt w-6"></i>
                    <span>Transaksi</span>
                </a>
                <a href="{{ route('laporan.index') }}" class="stagger-item nav-link {{ Request::is('laporan*') ? 'active' : '' }} flex items-center space-x-3 p-3 rounded-xl font-bold">
                    <i class="fas fa-chart-bar w-6"></i>
                    <span>Laporan</span>
                </a>
            </nav>

            <div class="stagger-item mt-10 border-t border-black/5 pt-6">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('main-sidebar');
            const items = document.querySelectorAll('.stagger-item');
            
            // Cek apakah baru login
            const isFromLogin = document.referrer.includes('login') || @json(session('success_login'));

            if (isFromLogin) {
                // Jalankan animasi sidebar
                sidebar.classList.add('animate-sidebar');

                // Jalankan animasi elemen di dalamnya satu per satu (delay bertahap)
                items.forEach((item, index) => {
                    setTimeout(() => {
                        item.classList.add('animate-stagger');
                    }, 400 + (index * 100)); // Delay awal 400ms, lalu jeda 100ms tiap item
                });
            } else {
                // Jika refresh/pindah menu biasa, langsung tampilkan semua tanpa animasi
                items.forEach(item => {
                    item.style.opacity = '1';
                });
            }
        });
    </script>
</body>
</html>
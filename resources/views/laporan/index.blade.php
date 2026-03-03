@extends('layouts.app')

@section('content')
<style>
    /* Animasi Masuk Utama - Halus & Blur */
    @keyframes slideInUp {
        from { 
            opacity: 0; 
            transform: translateY(40px); 
            /* filter: blur(10px); */
        }
        to { 
            opacity: 1; 
            transform: translateY(0); 
            filter: blur(0);
        }
    }

    @keyframes rowSlide {
        from { 
            opacity: 0; 
            transform: translateX(-30px); 
        }
        to { 
            opacity: 1; 
            transform: translateX(0); 
        }
    }

    /* Set default opacity 0 supaya tidak 'flicker' saat refresh */
    .animate-fade-up {
        opacity: 0;
        animation: slideInUp 0.8s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    .animate-row {
        opacity: 0;
        animation: rowSlide 0.6s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }

    /* Efek Hover Table */
    .table-row-hover {
        transition: all 0.3s ease;
    }
    .table-row-hover:hover {
        background-color: #fff1f2; /* pink-50 */
        transform: scale(1.005);
        z-index: 10;
        position: relative;
        box-shadow: inset 4px 0 0 #ec4899;
    }
</style>

<div class="max-w-6xl mx-auto px-4">
    <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4 animate-fade-up">
        <div>
            <h2 class="text-3xl font-black text-gray-800 uppercase tracking-tighter">Ringkasan Omset</h2>
            <p class="text-xs font-bold text-gray-400">PANTRAU CUAN KYUU 88</p>
        </div>
        
        <form action="{{ route('laporan.index') }}" method="GET" class="flex gap-2 bg-white p-3 rounded-2xl shadow-lg border-2 border-[#F2E3B6] hover:border-pink-300 transition-all">
            <input type="date" name="start_date" value="{{ request('start_date') }}" class="p-2 rounded-xl border-none outline-none font-bold text-gray-600 focus:bg-pink-50 transition">
            <span class="self-center font-black text-pink-300">/</span>
            <input type="date" name="end_date" value="{{ request('end_date') }}" class="p-2 rounded-xl border-none outline-none font-bold text-gray-600 focus:bg-pink-50 transition">
            <button type="submit" class="bg-pink-500 text-white px-8 py-2 rounded-xl font-black shadow-[0_5px_0_rgb(190,40,100)] active:shadow-none active:translate-y-1 transition-all">
                FILTER
            </button>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
        <div class="bg-[#F2E3B6] p-8 rounded-[40px] shadow-xl flex items-center justify-between border-b-8 border-black/10 group animate-fade-up" style="animation-delay: 0.1s">
            <div>
                <p class="text-gray-600 font-bold uppercase text-xs mb-1">Total Omset Periode</p>
                <h3 class="text-4xl font-black text-gray-900 tabular-nums">
                    Rp <span class="counter" data-target="{{ $total_omset_periode }}">0</span>
                </h3>
            </div>
            <div class="bg-white/30 p-4 rounded-3xl group-hover:rotate-12 transition-transform">
                <i class="fas fa-wallet text-5xl text-gray-800"></i>
            </div>
        </div>

        <div class="bg-white p-8 rounded-[40px] shadow-xl flex items-center justify-between border-b-8 border-pink-400 group animate-fade-up" style="animation-delay: 0.2s">
            <div>
                <p class="text-gray-400 font-bold uppercase text-xs mb-1">Rata-rata Harian</p>
                <h3 class="text-4xl font-black text-pink-500 tabular-nums">
                    @php $avg = $jumlah_hari > 0 ? $total_omset_periode / $jumlah_hari : 0; @endphp
                    Rp <span class="counter" data-target="{{ $avg }}">0</span>
                </h3>
            </div>
            <div class="bg-pink-50 p-4 rounded-3xl group-hover:scale-110 transition-transform">
                <i class="fas fa-chart-line text-5xl text-pink-400"></i>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-[40px] shadow-2xl overflow-hidden border-4 border-[#F2E3B6] animate-fade-up" style="animation-delay: 0.3s">
        <div class="p-6 bg-[#F2E3B6]/30 border-b-4 border-[#F2E3B6]">
             <h4 class="font-black text-gray-700 uppercase tracking-widest text-sm"><i class="fas fa-list mr-2"></i> Rincian Harian</h4>
        </div>
        <table class="w-full text-left">
            <thead class="bg-[#F2E3B6] text-gray-800 uppercase text-xs tracking-widest">
                <tr>
                    <th class="p-6">Tanggal</th>
                    <th class="p-6 text-right">Total Omset Harian</th>
                    <th class="p-6 text-center">Status</th>
                </tr>
            </thead>
            <tbody class="font-bold text-gray-700">
                @foreach($laporan_data as $index => $data)
                <tr class="animate-row border-b border-gray-100 table-row-hover transition-all duration-200" style="animation-delay: {{ 0.4 + ($index * 0.1) }}s">
                    <td class="p-6">
                        <div class="flex items-center gap-3">
                            <div class="w-2 h-8 bg-pink-400 rounded-full"></div>
                            {{ \Carbon\Carbon::parse($data->tanggal)->translatedFormat('d F Y') }}
                        </div>
                    </td>
                    <td class="p-6 text-right">
                        <span class="bg-green-50 text-green-600 px-4 py-2 rounded-2xl text-xl font-black">
                            Rp {{ number_format($data->total_omset) }}
                        </span>
                    </td>
                    <td class="p-6 text-center">
                        <span class="bg-green-100 text-green-600 px-4 py-1 rounded-full text-[10px] uppercase font-black border border-green-200">
                            <i class="fas fa-check-circle mr-1"></i> Recorded
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    // Script Counter Angka Berjalan - Lebih Slow & Smooth
    document.querySelectorAll('.counter').forEach(counter => {
        const target = +counter.getAttribute('data-target');
        let current = 0;
        const duration = 2000; // Durasi 2 detik
        const frameRate = 1000 / 60;
        const totalFrames = Math.round(duration / frameRate);
        let frame = 0;

        // Efek Ease-Out: cepat di awal, pelan di akhir
        const easeOutExpo = t => t === 1 ? 1 : 1 - Math.pow(2, -10 * t);

        const updateCount = () => {
            frame++;
            const progress = easeOutExpo(frame / totalFrames);
            current = target * progress;

            if (frame < totalFrames) {
                counter.innerText = Math.floor(current).toLocaleString('id-ID');
                requestAnimationFrame(updateCount);
            } else {
                counter.innerText = target.toLocaleString('id-ID');
            }
        };

        // Mulai setelah delay sedikit agar sinkron dengan animasi kartu
        setTimeout(() => {
            requestAnimationFrame(updateCount);
        }, 400);
    });
</script>
@endsection
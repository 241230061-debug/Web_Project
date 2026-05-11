<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | The Gentry's Blade</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body class="bg-zinc-950 text-zinc-100 antialiased">

    <nav class="fixed w-full z-50 bg-zinc-950/90 backdrop-blur-md border-b border-zinc-800">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <div class="flex items-center gap-2">
                <div class="w-10 h-10 bg-amber-500 rounded-lg flex items-center justify-center rotate-3 group hover:rotate-0 transition-transform">
                    <svg class="w-6 h-6 text-zinc-950" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19m-7-7l7-7m-7 7l-2.879 2.879M12 12L9.121 9.121m0 5.758a3 3 0 10-4.243-4.243 3 3 0 004.243 4.243z"></path></svg>
                </div>
                <span class="text-xl font-black uppercase tracking-tighter">Barber<span class="text-amber-500">Slebew</span></span>
            </div>

            <div class="hidden md:flex gap-10 items-center">
        <div class="hidden md:flex gap-10 items-center">
            <a href="{{ route('beranda') }}" class="text-sm font-bold uppercase tracking-widest hover:text-amber-500">Beranda</a>
            <a href="{{ route('harga') }}" class="text-sm font-bold uppercase tracking-widest hover:text-amber-500">Lihat Harga</a>
            <a href="{{ route('kontak') }}" class="bg-amber-500 text-zinc-950 px-6 py-2 rounded-sm font-black text-sm uppercase tracking-widest">Book Now</a>
        </div>
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="bg-zinc-900 border-t border-zinc-800 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12 mb-12">
            <div>
                <h4 class="text-amber-500 font-bold uppercase tracking-widest mb-6 italic">The Gentry's Blade</h4>
                <p class="text-zinc-400 leading-relaxed">Barbershop premium yang menggabungkan teknik pangkas klasik dengan kenyamanan modern untuk pria sejati.</p>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase tracking-widest mb-6">Jam Buka</h4>
                <ul class="text-zinc-400 space-y-2">
                    <li class="flex justify-between"><span>Senin - Jumat</span> <span>10:00 - 21:00</span></li>
                    <li class="flex justify-between"><span>Sabtu - Minggu</span> <span>09:00 - 22:00</span></li>
                </ul>
            </div>
            <div>
                <h4 class="text-white font-bold uppercase tracking-widest mb-6">Kontak Kami</h4>
                <p class="text-zinc-400 italic">Jl. Sudirman No. 26, Jakarta Pusat</p>
                <p class="text-amber-500 font-bold mt-2">+62 812 3456 789</p>
            </div>
        </div>
        <div class="border-t border-zinc-800 pt-8 text-center">
            <p class="text-zinc-500 text-xs tracking-widest uppercase">© 2026 WebProject_2026. Design by AI Assistant.</p>
        </div>
    </footer>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        duration: 1000, // Durasi animasi (1 detik)
        once: true,     // Animasi hanya jalan sekali saat di-scroll
        offset: 100     // Jarak scroll sebelum animasi mulai
    });
</script>
</body>
</html>
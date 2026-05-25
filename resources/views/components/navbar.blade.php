<nav class="fixed w-full top-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-md shadow-md border-b border-slate-100 h-20 flex items-center"
    id="navbar">
    <div class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-full">

            <!-- Brand Logo (Left) -->
            <a href="{{ url('/') }}" class="flex items-center gap-3 group shrink-0">
                <div
                    class="w-10 h-10 bg-slate-900 rounded-xl flex items-center justify-center group-hover:bg-[#1A875A] transition-colors duration-300">
                    <i class="ph-fill ph-leaf text-white text-xl"></i>
                </div>
                <span class="text-2xl font-black text-slate-900 tracking-tight">
                    Go<span class="text-[#1A875A]">Sheep</span>
                </span>
            </a>

            <!-- Desktop Navigation Links (Center) -->
            <div class="hidden lg:flex items-center gap-6 xl:gap-8">
                <!-- Beranda Pill Button (Green Theme) -->
                <a href="{{ url('/#beranda') }}"
                    class="bg-[#1A875A] text-white rounded-full font-bold px-6 py-2.5 shadow-md shadow-[#1A875A]/25 transition-all hover:bg-[#146b47] hover:shadow-lg text-sm whitespace-nowrap">
                    Beranda
                </a>

                <a href="{{ route('fitur') }}"
                    class="text-sm font-bold text-slate-600 hover:text-[#1A875A] transition-colors whitespace-nowrap">
                    Layanan
                </a>

                <a href="{{ url('/#aplikasi-mobile') }}"
                    class="text-sm font-bold text-slate-600 hover:text-[#1A875A] transition-colors whitespace-nowrap">
                    Aplikasi
                </a>

                <a href="{{ url('/#galeri') }}"
                    class="text-sm font-bold text-slate-600 hover:text-[#1A875A] transition-colors whitespace-nowrap">
                    Galeri
                </a>

                <a href="{{ url('/#about-dombaku') }}"
                    class="text-sm font-bold text-slate-600 hover:text-[#1A875A] transition-colors whitespace-nowrap">
                    Tentang Kami
                </a>
            </div>

            <!-- Desktop Right Actions (Right) -->
            <div class="hidden lg:flex items-center gap-4 shrink-0">
                <!-- Masuk Button -->
                <a href="{{ route('login') }}"
                    class="inline-flex items-center justify-center gap-2 bg-[#1A875A] hover:bg-[#146b47] px-6 py-2.5 rounded-full transition-all duration-300 shadow-md shadow-[#1A875A]/20 hover:-translate-y-0.5 group">
                    <span class="text-sm font-bold text-white leading-tight">Masuk</span>
                    <i
                        class="ph-bold ph-arrow-right text-white opacity-70 group-hover:translate-x-0.5 transition-transform text-xs"></i>
                </a>
            </div>

            <!-- Mobile Actions (Right) -->
            <div class="flex items-center gap-3 lg:hidden shrink-0">
                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn"
                    class="text-slate-900 bg-slate-50 p-2.5 border border-slate-200 rounded-xl transition hover:bg-slate-100 focus:outline-none">
                    <i id="menu-icon" class="ph-bold ph-list text-xl"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Full-Width Mobile Navigation Menu (100% Solid White, Highly Readable) -->
    <div id="mobile-menu"
        class="hidden absolute top-20 left-0 right-0 w-full bg-white border-b border-slate-200 px-6 py-6 shadow-2xl transition-all duration-300 scale-y-0 opacity-0 transform origin-top z-50">
        <div class="flex flex-col gap-3.5 max-w-7xl mx-auto">
            <a href="{{ url('/#beranda') }}"
                class="bg-[#1A875A] text-white text-center py-3.5 rounded-xl font-bold shadow-lg shadow-[#1A875A]/25 transition-all text-[15px]">Beranda</a>
            <a href="{{ route('fitur') }}"
                class="text-slate-700 font-semibold px-4 py-3 hover:bg-slate-50 hover:text-[#1A875A] rounded-xl transition text-[15px] border-b border-slate-100/60">Layanan</a>
            <a href="{{ url('/#aplikasi-mobile') }}"
                class="text-slate-700 font-semibold px-4 py-3 hover:bg-slate-50 hover:text-[#1A875A] rounded-xl transition text-[15px] border-b border-slate-100/60">Aplikasi
                Mobile</a>
            <a href="{{ url('/#galeri') }}"
                class="text-slate-700 font-semibold px-4 py-3 hover:bg-slate-50 hover:text-[#1A875A] rounded-xl transition text-[15px] border-b border-slate-100/60">Galeri</a>
            <a href="{{ url('/#about-dombaku') }}"
                class="text-slate-700 font-semibold px-4 py-3 hover:bg-slate-50 hover:text-[#1A875A] rounded-xl transition text-[15px]">Tentang
                Kami</a>

            <div class="h-px bg-slate-100 my-1"></div>

            <a href="{{ route('login') }}"
                class="text-white bg-[#1A875A] hover:bg-[#146b47] text-center py-3.5 rounded-xl font-bold shadow-md shadow-[#1A875A]/20 transition-all text-[15px]">Masuk
                ke Dashboard</a>
        </div>
    </div>
</nav>

<footer id="footer" class="relative overflow-hidden font-sans bg-white border-t border-slate-100">

    {{-- Subtle top accent bar --}}
    <div class="h-1 w-full"
        style="background: linear-gradient(90deg, #059669, #10b981, #34d399, #10b981, #059669);"></div>

    {{-- Newsletter CTA Strip --}}
    <div class="border-b border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
            <div
                class="flex flex-col lg:flex-row items-center justify-between gap-6 rounded-2xl p-7 bg-emerald-50 border border-emerald-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow"
                        style="background: linear-gradient(135deg, #059669, #10b981);">
                        <i class="ph-fill ph-bell-ringing text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-slate-800 font-black text-lg mb-0.5">Dapatkan Update Terbaru GoSheep</h3>
                        <p class="text-sm text-slate-500">Notifikasi fitur baru dan tips peternakan langsung ke
                            email Anda.</p>
                    </div>
                </div>
                <div class="flex gap-3 w-full lg:w-auto flex-col sm:flex-row">
                    <input type="email" placeholder="Masukkan email Anda..."
                        class="px-5 py-3 rounded-xl text-sm font-medium outline-none w-full sm:w-64 border border-slate-200 bg-white text-slate-700 transition-all focus:border-emerald-400 focus:ring-2 focus:ring-emerald-100">
                    <button
                        class="px-6 py-3 rounded-xl font-bold text-sm text-white whitespace-nowrap transition-all duration-300 hover:-translate-y-0.5 active:scale-95"
                        style="background: linear-gradient(135deg, #059669, #10b981); box-shadow: 0 4px 14px rgba(16,185,129,0.3);">
                        <i class="ph-bold ph-paper-plane-right mr-1.5"></i> Berlangganan
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Footer Content --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-10">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12 lg:gap-8 mb-12">

            {{-- Brand Column --}}
            <div class="lg:col-span-4">
                <a href="#" class="flex items-center gap-3 mb-5 group">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center text-white shadow-md group-hover:rotate-12 transition-all duration-300 p-2.5"
                        style="background: linear-gradient(135deg, #059669, #10b981);">
                        <i class="ph-fill ph-leaf text-2xl"></i>
                    </div>
                    <div>
                        <span class="text-2xl font-black text-slate-900 tracking-tight">Go<span
                                class="text-emerald-500">Sheep</span></span>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400 mt-0.5">Smart
                            Livestock Platform</p>
                    </div>
                </a>

                <p class="text-[14.5px] text-slate-500 leading-relaxed mb-6 max-w-sm">
                    Platform manajemen ternak berbasis <span class="font-semibold text-slate-700">Machine
                        Learning</span>. Membantu peternak modern mengelola data, kesehatan, dan genetik ternak
                    secara efisien.
                </p>

                {{-- Stats badges --}}
                <div class="flex flex-wrap gap-2 mb-6">
                    <div
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <i class="ph-fill ph-sheep text-sm"></i> 1.200+ Ternak Terdaftar
                    </div>
                    <div
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold bg-emerald-50 text-emerald-700 border border-emerald-100">
                        <i class="ph-fill ph-users text-sm"></i> 300+ Peternak Aktif
                    </div>
                </div>

                {{-- Social Media --}}
                <div>
                    <p class="text-xs font-bold uppercase tracking-widest text-slate-400 mb-3">Ikuti Kami</p>
                    <div class="flex gap-2">
                        <a href="#" title="Instagram"
                            class="w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 transition-all duration-200 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 hover:-translate-y-0.5">
                            <i class="ph-fill ph-instagram-logo text-base"></i>
                        </a>
                        <a href="#" title="GitHub"
                            class="w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 transition-all duration-200 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 hover:-translate-y-0.5">
                            <i class="ph-fill ph-github-logo text-base"></i>
                        </a>
                        <a href="#" title="YouTube"
                            class="w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 transition-all duration-200 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 hover:-translate-y-0.5">
                            <i class="ph-fill ph-youtube-logo text-base"></i>
                        </a>
                        <a href="#" title="WhatsApp"
                            class="w-9 h-9 rounded-lg flex items-center justify-center border border-slate-200 text-slate-400 transition-all duration-200 hover:border-emerald-400 hover:text-emerald-600 hover:bg-emerald-50 hover:-translate-y-0.5">
                            <i class="ph-fill ph-whatsapp-logo text-base"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Navigasi Column --}}
            <div class="lg:col-span-2 lg:col-start-6">
                <h4
                    class="font-black text-slate-800 mb-5 uppercase text-xs tracking-[0.18em] flex items-center gap-2">
                    <span class="w-4 h-0.5 rounded-full bg-emerald-500"></span> Navigasi
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#beranda"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-house text-xs text-emerald-400"></i> Beranda
                        </a>
                    </li>
                    <li>
                        <a href="#about-dombaku"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-info text-xs text-emerald-400"></i> Tentang GoSheep
                        </a>
                    </li>
                    <li>
                        <a href="#layanan"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-squares-four text-xs text-emerald-400"></i> Layanan
                        </a>
                    </li>
                    <li>
                        <a href="#aplikasi-mobile"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-device-mobile text-xs text-emerald-400"></i> Aplikasi Mobile
                        </a>
                    </li>
                    <li>
                        <a href="#galeri"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-images text-xs text-emerald-400"></i> Galeri
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('login') }}"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-sign-in text-xs text-emerald-400"></i> Masuk Dashboard
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Fitur Column --}}
            <div class="lg:col-span-2">
                <h4
                    class="font-black text-slate-800 mb-5 uppercase text-xs tracking-[0.18em] flex items-center gap-2">
                    <span class="w-4 h-0.5 rounded-full bg-emerald-500"></span> Fitur Utama
                </h4>
                <ul class="space-y-3">
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-chart-bar text-xs text-emerald-400"></i> Manajemen Data Ternak
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-tree-structure text-xs text-emerald-400"></i> Rekomendasi Kawin
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-heartbeat text-xs text-emerald-400"></i> Monitoring Kesehatan
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-file-text text-xs text-emerald-400"></i> Laporan & Analitik
                        </a>
                    </li>
                    <li>
                        <a href="#"
                            class="flex items-center gap-2 text-sm text-slate-500 font-medium hover:text-emerald-600 hover:translate-x-1 transition-all duration-200">
                            <i class="ph-bold ph-bell text-xs text-emerald-400"></i> Notifikasi Real-time
                        </a>
                    </li>
                </ul>
            </div>

            {{-- Contact Column --}}
            <div class="lg:col-span-3 lg:col-start-10">
                <h4
                    class="font-black text-slate-800 mb-5 uppercase text-xs tracking-[0.18em] flex items-center gap-2">
                    <span class="w-4 h-0.5 rounded-full bg-emerald-500"></span> Hubungi Kami
                </h4>

                <div class="space-y-3">
                    <div
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-student text-base text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Tim
                                Pengembang</p>
                            <p class="text-sm font-semibold text-slate-700">PBL TRPL-605</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-map-pin text-base text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Lokasi
                            </p>
                            <p class="text-sm font-semibold text-slate-700">Polibatam, Batam — Kepri</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-3 p-3 rounded-xl border border-slate-100 hover:border-emerald-200 hover:bg-emerald-50/50 transition-all duration-200">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-envelope-simple text-base text-white"></i>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-0.5">Email
                            </p>
                            <a href="mailto:halo@gosheep.id"
                                class="text-sm font-semibold text-slate-700 hover:text-emerald-600 transition-colors">halo@gosheep.id</a>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2 px-3 py-2.5 rounded-xl bg-emerald-50 border border-emerald-100">
                        <span class="relative flex h-2 w-2 flex-shrink-0">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                        </span>
                        <span class="text-xs font-semibold text-emerald-700">Sistem Operasional — 99.9% Uptime</span>
                    </div>
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="flex flex-col md:flex-row justify-between items-center gap-3 border-t border-slate-100 pt-6">
            <div class="flex items-center gap-2.5">
                <div class="w-6 h-6 rounded-md flex items-center justify-center bg-emerald-500">
                    <i class="ph-fill ph-leaf text-white text-xs"></i>
                </div>
                <p class="text-sm text-slate-400 font-medium">
                    &copy; 2024 <span class="font-bold text-slate-600">GoSheep</span> · Hak Cipta Dilindungi
                </p>
            </div>
            <div class="flex items-center gap-1 text-sm text-slate-400">
                Dibuat dengan <i class="ph-fill ph-heart animate-pulse mx-1 text-rose-400"></i> dan
                <i class="ph-fill ph-coffee mx-1 text-amber-400"></i> di
                <span class="font-semibold text-emerald-600 ml-1">Batam, Indonesia</span>
            </div>
        </div>

    </div>
</footer>

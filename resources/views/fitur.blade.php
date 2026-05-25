<x-layouts.public title="Fitur GoSheep — Platform Manajemen Ternak Cerdas"
    description="Jelajahi fitur-fitur canggih GoSheep: manajemen data ternak, rekomendasi kawin berbasis AI, monitoring kesehatan, dan laporan analitik lengkap.">

    {{-- ===== HERO SECTION ===== --}}
    <section class="pt-36 pb-20 relative overflow-hidden">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-0 right-0 w-[500px] h-[500px] rounded-full"
                style="background: radial-gradient(circle, rgba(16,185,129,0.08) 0%, transparent 70%); transform: translate(20%, -20%);"></div>
            <div class="absolute bottom-0 left-0 w-[400px] h-[400px] rounded-full"
                style="background: radial-gradient(circle, rgba(5,150,105,0.06) 0%, transparent 70%); transform: translate(-20%, 20%);"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto" data-aos="fade-up">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-700 text-sm font-bold mb-6">
                    <i class="ph-fill ph-star text-emerald-500"></i>
                    Platform Manajemen Ternak Terlengkap
                </div>
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight mb-6 tracking-tight">
                    Semua Fitur yang Anda <br>
                    <span class="text-transparent bg-clip-text"
                        style="background-image: linear-gradient(135deg, #059669, #10b981, #34d399);">Butuhkan</span> Ada di Sini
                </h1>
                <p class="text-lg text-slate-500 leading-relaxed mb-10 max-w-2xl mx-auto">
                    GoSheep menghadirkan ekosistem digital lengkap untuk peternak modern — dari pencatatan data, rekomendasi kawin berbasis AI, hingga laporan analitik yang komprehensif.
                </p>
            </div>

            {{-- Stats row --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5 mt-14" data-aos="fade-up" data-aos-delay="200">
                <div class="text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="text-3xl font-black text-emerald-600 mb-1">1.200+</div>
                    <div class="text-sm text-slate-500 font-medium">Ternak Terdaftar</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="text-3xl font-black text-emerald-600 mb-1">300+</div>
                    <div class="text-sm text-slate-500 font-medium">Peternak Aktif</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="text-3xl font-black text-emerald-600 mb-1">99.9%</div>
                    <div class="text-sm text-slate-500 font-medium">Uptime Sistem</div>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl border border-slate-100 shadow-sm hover:shadow-md hover:-translate-y-1 transition-all duration-300">
                    <div class="text-3xl font-black text-emerald-600 mb-1">95%</div>
                    <div class="text-sm text-slate-500 font-medium">Akurasi AI</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ===== FITUR UTAMA (3 Cards) ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-aos="fade-up">
                <p class="inline-block text-emerald-600 font-bold tracking-widest uppercase text-sm px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 mb-4">
                    Fitur Unggulan
                </p>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900 leading-tight">Tiga Pilar Utama GoSheep</h2>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Card 1: Manajemen Data --}}
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                    data-aos="fade-up" data-aos-delay="100">
                    <div class="h-2 w-full" style="background: linear-gradient(90deg, #059669, #10b981);"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-md"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-chart-bar text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3">Manajemen Data Ternak</h3>
                        <p class="text-slate-500 text-[15px] leading-relaxed mb-6">
                            Catat dan pantau seluruh data ternak Anda dalam satu platform terpusat. Profil individu domba, riwayat kesehatan, hingga silsilah — semua tersimpan digital.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            @foreach(['Profil lengkap per ekor domba', 'Rekam medis & riwayat vaksinasi', 'Pencatatan kelahiran & kematian', 'Data berat badan & pertumbuhan', 'Manajemen kandang & kelompok'] as $item)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600">
                                <i class="ph-fill ph-check-circle text-emerald-500 text-lg flex-shrink-0"></i>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="px-8 pb-8">
                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="text-slate-400">Tersedia di</span>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">Web</span>
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">Mobile</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Rekomendasi Kawin --}}
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                    data-aos="fade-up" data-aos-delay="200">
                    <div class="h-2 w-full" style="background: linear-gradient(90deg, #059669, #10b981);"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-md"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-tree-structure text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3">Rekomendasi Kawin AI</h3>
                        <p class="text-slate-500 text-[15px] leading-relaxed mb-6">
                            Algoritma Machine Learning menganalisis data genetik untuk merekomendasikan pasangan kawin terbaik. Hasilkan keturunan berkualitas, bebas inbreeding.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            @foreach(['Analisis koefisien inbreeding otomatis', 'Prediksi kualitas keturunan', 'Skor kompatibilitas genetik (0–100)', 'Jadwal kawin + notifikasi otomatis', 'Riwayat perkawinan lengkap'] as $item)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600">
                                <i class="ph-fill ph-check-circle text-emerald-500 text-lg flex-shrink-0"></i>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="px-8 pb-8">
                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="text-slate-400">Akurasi AI</span>
                            <div class="flex items-center gap-2">
                                <div class="w-24 h-2 bg-slate-100 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: 95%"></div>
                                </div>
                                <span class="text-emerald-600 font-bold text-xs">95%</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 3: Laporan --}}
                <div class="group bg-white rounded-3xl border border-slate-100 shadow-sm overflow-hidden transition-all duration-300 hover:-translate-y-2 hover:shadow-xl"
                    data-aos="fade-up" data-aos-delay="300">
                    <div class="h-2 w-full" style="background: linear-gradient(90deg, #059669, #10b981);"></div>
                    <div class="p-8">
                        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6 shadow-md"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill ph-chart-pie text-white text-2xl"></i>
                        </div>
                        <h3 class="text-xl font-black text-slate-900 mb-3">Laporan & Analitik</h3>
                        <p class="text-slate-500 text-[15px] leading-relaxed mb-6">
                            Insight mendalam dari data peternakan melalui visualisasi chart yang intuitif. Buat keputusan bisnis lebih cerdas berdasarkan data nyata.
                        </p>
                        <ul class="space-y-2.5 mb-6">
                            @foreach(['Grafik distribusi domba per umur/jenis', 'Statistik kelahiran & kematian bulanan', 'Tren pertumbuhan berat badan', 'Ringkasan kesehatan populasi', 'Export laporan PDF / Excel'] as $item)
                            <li class="flex items-center gap-2.5 text-sm text-slate-600">
                                <i class="ph-fill ph-check-circle text-emerald-500 text-lg flex-shrink-0"></i>
                                {{ $item }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="px-8 pb-8">
                        <div class="pt-5 border-t border-slate-100 flex items-center justify-between text-sm">
                            <span class="text-slate-400">Tersedia di</span>
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-semibold">Web</span>
                                <span class="px-2.5 py-1 bg-slate-100 text-slate-500 rounded-full text-xs font-semibold">Segera</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FITUR DASHBOARD ADMIN & OWNER ===== --}}
    <section class="py-24 bg-slate-900 relative overflow-hidden font-sans">
        <div class="absolute inset-0 pointer-events-none">
            <div class="absolute top-[-20%] left-[-10%] w-[500px] h-[500px] bg-emerald-500/20 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[500px] h-[500px] bg-teal-500/20 rounded-full blur-[150px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                
                <div class="w-full lg:w-1/2" data-aos="fade-right">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 border border-white/20 text-emerald-300 text-sm font-bold mb-6 backdrop-blur-sm">
                        <i class="ph-fill ph-monitor text-emerald-400"></i>
                        Portal Manajemen Khusus
                    </div>
                    <h2 class="text-4xl md:text-5xl font-black text-white leading-tight mb-6">
                        Kendali Penuh di Tangan <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-400">Admin & Owner</span>
                    </h2>
                    <p class="text-slate-300 text-lg leading-relaxed mb-8">
                        Dapatkan akses eksklusif ke Dashboard Admin SIAKAD-Style yang super cepat dan responsif. Semua modul dirancang untuk memudahkan manajemen operasional harian peternakan Anda.
                    </p>

                    <div class="space-y-8 mt-8">
                        <!-- Master Data -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <i class="ph-bold ph-folder-open text-emerald-400 text-xl"></i>
                                <h4 class="text-emerald-400 font-black tracking-widest text-sm uppercase">Master Data</h4>
                            </div>
                            <ul class="space-y-4 pl-6 border-l-2 border-white/10 ml-[9px]">
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-tent text-emerald-400"></i>
                                    </div>
                                    Kandang
                                </li>
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-tag text-emerald-400"></i>
                                    </div>
                                    Ternak Domba
                                </li>
                            </ul>
                        </div>

                        <!-- Pencatatan -->
                        <div>
                            <div class="flex items-center gap-2 mb-4">
                                <i class="ph-bold ph-folder-open text-teal-400 text-xl"></i>
                                <h4 class="text-teal-400 font-black tracking-widest text-sm uppercase">Pencatatan</h4>
                            </div>
                            <ul class="space-y-4 pl-6 border-l-2 border-white/10 ml-[9px]">
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-heartbeat text-teal-400"></i>
                                    </div>
                                    Catatan Kesehatan
                                </li>
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-git-merge text-teal-400"></i>
                                    </div>
                                    Persilangan (Mating)
                                </li>
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-scale text-teal-400"></i>
                                    </div>
                                    Riwayat Berat
                                </li>
                                <li class="flex items-center gap-3 text-slate-300 relative before:content-[''] before:absolute before:-left-[1.65rem] before:top-1/2 before:w-4 before:h-[2px] before:bg-white/10 font-medium">
                                    <div class="w-8 h-8 rounded-lg bg-white/5 flex items-center justify-center border border-white/10 shrink-0">
                                        <i class="ph-fill ph-user-list text-teal-400"></i>
                                    </div>
                                    Akun Peternak
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="w-full lg:w-1/2 relative" data-aos="fade-left">
                    <div class="relative rounded-2xl overflow-hidden border-4 border-slate-800 shadow-[0_20px_50px_rgba(0,0,0,0.5)] transform lg:rotate-2 hover:rotate-0 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900 via-transparent to-transparent opacity-50"></div>
                        <div class="h-8 bg-slate-800 flex items-center px-4 gap-2">
                            <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                            <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                            <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                        </div>
                        <div class="bg-slate-50 p-6 h-[400px] flex items-center justify-center">
                            <div class="text-center">
                                <i class="ph-fill ph-layout text-6xl text-slate-300 mb-4 block"></i>
                                <p class="text-slate-500 font-bold uppercase tracking-widest text-sm">Preview Dashboard Admin</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="absolute -bottom-6 -left-6 bg-emerald-500 text-white p-5 rounded-2xl shadow-xl border border-emerald-400 animate-bounce-slow">
                        <div class="flex items-center gap-3">
                            <i class="ph-fill ph-shield-check text-3xl"></i>
                            <div>
                                <p class="text-xs font-bold uppercase tracking-widest text-emerald-100">Hak Akses</p>
                                <p class="text-lg font-black">Khusus Admin</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    {{-- ===== FITUR PENDUKUNG ===== --}}
    <section class="py-20 bg-[#FAFAFA]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <p class="inline-block text-emerald-600 font-bold tracking-widest uppercase text-sm px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 mb-4">Lebih Lengkap</p>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900">Fitur Pendukung Lainnya</h2>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                @php
                $features = [
                    ['icon' => 'ph-bell-ringing',   'title' => 'Notifikasi Real-time',      'desc' => 'Peringatan otomatis untuk jadwal vaksinasi, kawin, dan pemeriksaan kesehatan domba.', 'tag' => 'Web & Mobile'],
                    ['icon' => 'ph-device-mobile',   'title' => 'Aplikasi Mobile (DombaKu)', 'desc' => 'Input data langsung dari kandang. Sinkronisasi otomatis ke server cloud.', 'tag' => 'Android'],
                    ['icon' => 'ph-shield-check',    'title' => 'Keamanan Data 100%',         'desc' => 'Data terenkripsi standar keamanan tinggi. Hanya Anda yang dapat mengaksesnya.', 'tag' => 'Enkripsi SSL'],
                    ['icon' => 'ph-users-three',     'title' => 'Multi-Role Akses',           'desc' => 'Kelola tim dengan role Owner, Staff, dan Peternak dengan hak akses berbeda.', 'tag' => 'Manajemen Tim'],
                    ['icon' => 'ph-cloud-arrow-up',  'title' => 'Cloud Backup Otomatis',      'desc' => 'Data dicadangkan setiap hari ke server cloud yang aman dan terpercaya.', 'tag' => 'Cloud'],
                    ['icon' => 'ph-headset',          'title' => 'Dukungan Teknis',            'desc' => 'Tim kami siap membantu via email & WhatsApp setiap hari kerja 08.00–17.00 WIB.', 'tag' => 'Support'],
                ];
                @endphp

                @foreach($features as $i => $f)
                <div class="bg-white rounded-2xl border border-slate-100 p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-md hover:border-emerald-100"
                    data-aos="fade-up" data-aos-delay="{{ ($i % 3) * 100 + 100 }}">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0"
                            style="background: linear-gradient(135deg, #059669, #10b981);">
                            <i class="ph-fill {{ $f['icon'] }} text-white text-xl"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between gap-2 mb-2 flex-wrap">
                                <h4 class="font-black text-slate-800 text-[15px]">{{ $f['title'] }}</h4>
                                <span class="text-[10px] font-bold bg-emerald-50 text-emerald-700 px-2 py-0.5 rounded-full whitespace-nowrap border border-emerald-100">{{ $f['tag'] }}</span>
                            </div>
                            <p class="text-slate-500 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CARA KERJA ===== --}}
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-14" data-aos="fade-up">
                <p class="inline-block text-emerald-600 font-bold tracking-widest uppercase text-sm px-4 py-2 rounded-full bg-emerald-50 border border-emerald-100 mb-4">Mudah Digunakan</p>
                <h2 class="text-3xl md:text-4xl font-black text-slate-900">Mulai dalam 3 Langkah</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                @php $steps = [
                    ['num' => '1', 'title' => 'Daftar & Login', 'desc' => 'Buat akun GoSheep dan login ke dashboard. Proses registrasi hanya butuh 2 menit.'],
                    ['num' => '2', 'title' => 'Input Data Ternak', 'desc' => 'Masukkan data domba melalui web dashboard atau aplikasi mobile DombaKu langsung dari kandang.'],
                    ['num' => '3', 'title' => 'Dapatkan Rekomendasi', 'desc' => 'AI GoSheep menganalisis data dan memberikan rekomendasi pasangan kawin terbaik secara otomatis.'],
                ]; @endphp

                @foreach($steps as $i => $s)
                <div class="text-center" data-aos="fade-up" data-aos-delay="{{ ($i + 1) * 100 }}">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-5 flex items-center justify-center text-white text-2xl font-black shadow-lg"
                        style="background: linear-gradient(135deg, #059669, #10b981);">
                        {{ $s['num'] }}
                    </div>
                    <h4 class="font-black text-slate-800 text-lg mb-3">{{ $s['title'] }}</h4>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $s['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ===== CTA ===== --}}
    <section class="py-20">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl p-12 text-center relative overflow-hidden"
                style="background: linear-gradient(135deg, #0d2b1a 0%, #059669 100%);" data-aos="fade-up">
                <div class="absolute inset-0 pointer-events-none"
                    style="background: radial-gradient(circle at 70% 50%, rgba(52,211,153,0.2) 0%, transparent 60%);"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 rounded-2xl mx-auto mb-6 flex items-center justify-center bg-white/20 backdrop-blur-sm">
                        <i class="ph-fill ph-leaf text-white text-3xl"></i>
                    </div>
                    <h2 class="text-3xl md:text-4xl font-black text-white mb-4">Siap Kelola Ternak Lebih Cerdas?</h2>
                    <p class="text-emerald-100 text-lg mb-8 max-w-xl mx-auto">Bergabung dengan ratusan peternak yang sudah menggunakan GoSheep untuk meningkatkan produktivitas.</p>
                    <div class="flex flex-wrap gap-4 justify-center">
                        <a href="{{ route('login') }}"
                            class="px-8 py-4 rounded-full font-bold bg-white text-emerald-700 transition-all hover:-translate-y-0.5 shadow-lg hover:shadow-xl">
                            Mulai Gratis <i class="ph-bold ph-arrow-right ml-1"></i>
                        </a>
                        <a href="/#aplikasi-mobile"
                            class="px-8 py-4 rounded-full font-bold text-white border-2 border-white/30 hover:bg-white/10 transition-all hover:-translate-y-0.5">
                            Download Aplikasi
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</x-layouts.public>

<x-layouts.public title="DombaKu - Ekosistem Cerdas Peternakan Modern">

    <section id="beranda" class="relative min-h-screen flex items-center justify-center pt-20 pb-16 overflow-hidden">
        <div class="absolute inset-0 -z-20">
            <video autoplay muted loop playsinline class="w-full h-full object-cover scale-105">
                <source src="{{ asset('assets/img/background.mp4') }}" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <div class="absolute inset-0 bg-slate-900/50 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-b from-slate-900/40 via-transparent to-white/90"></div>
        </div>

        <div
            class="absolute top-[-10%] right-[-5%] w-[600px] h-[600px] bg-emerald-500/10 rounded-full mix-blend-screen filter blur-[120px] animate-blob -z-10">
        </div>
        <div
            class="absolute bottom-[10%] left-[-10%] w-[500px] h-[500px] bg-blue-500/10 rounded-full mix-blend-screen filter blur-[120px] animate-blob animation-delay-2000 -z-10">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-4xl mx-auto" data-aos="fade-up" data-aos-duration="1200">

                <div
                    class="inline-flex items-center gap-3 px-5 py-2 rounded-full bg-white/10 backdrop-blur-md border border-white/20 shadow-2xl text-sm font-semibold mb-8 text-white hover:bg-white/20 transition-all duration-300 cursor-pointer group">
                    <span class="flex h-3 w-3 relative">
                        <span
                            class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                    </span>
                    <span>Selamat Datang di GoSheep!</span>
                    <i class="ph-bold ph-hand-waving text-emerald-400 group-hover:rotate-12 transition-transform"></i>
                </div>

                <h1
                    class="text-4xl md:text-6xl lg:text-7xl font-black text-white leading-[1.1] mb-8 tracking-tight drop-shadow-2xl">
                    Solusi Cerdas <br class="hidden md:block">
                    Peternakan
                    <span class="relative inline-block">
                        <span
                            class="relative z-10 text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-emerald-500 to-teal-400">
                            GoSheep
                        </span>
                        <span class="absolute bottom-2 left-0 w-full h-2 bg-emerald-500/20 -z-10 rounded-full"></span>
                    </span>
                </h1>

                <p
                    class="text-lg md:text-xl text-slate-200 mb-12 max-w-2xl mx-auto leading-relaxed font-medium drop-shadow-lg">
                    Kelola peternakan domba Anda lebih modern dan menguntungkan.
                    Manfaatkan teknologi <span class="text-emerald-400 font-bold">AI</span> untuk memantau kesehatan dan
                    memaksimalkan potensi genetik.
                </p>

                <div class="flex flex-wrap justify-center gap-4">
                    <a href="#fitur"
                        class="px-8 py-4 bg-emerald-500 hover:bg-emerald-600 text-white rounded-full font-bold transition-all shadow-lg shadow-emerald-500/25 flex items-center gap-2">
                        Mulai Sekarang
                        <i class="ph-bold ph-arrow-right"></i>
                    </a>
                    <a href="#app"
                        class="px-8 py-4 bg-white/10 backdrop-blur-md border border-white/30 text-white hover:bg-white/20 rounded-full font-bold transition-all">
                        Lihat Demo
                    </a>
                </div>

            </div>
        </div>
    </section>

    <section
        class="py-10 border-y border-slate-200/50 bg-white/30 backdrop-blur-sm overflow-hidden flex flex-col items-center">
        <p
            class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 relative z-10 bg-[#F8FAFC] px-4 rounded-full">
            Dikembangkan & Didukung Oleh</p>

        <div class="relative flex w-full overflow-hidden">
            <div
                class="flex whitespace-nowrap animate-marquee items-center gap-16 md:gap-24 opacity-50 hover:opacity-100 transition-opacity duration-300">
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-student text-3xl md:text-4xl text-accent"></i> PBL 404</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-buildings text-3xl md:text-4xl text-blue-500"></i> Polibatam</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-code text-3xl md:text-4xl text-red-500"></i> Laravel Tech</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-wind text-3xl md:text-4xl text-sky-400"></i> Tailwind CSS</div>

                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2 ml-16 md:ml-24"><i
                        class="ph-fill ph-student text-3xl md:text-4xl text-accent"></i> PBL 404</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-buildings text-3xl md:text-4xl text-blue-500"></i> Polibatam</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2"><i
                        class="ph-fill ph-code text-3xl md:text-4xl text-red-500"></i> Laravel Tech</div>
                <div class="text-xl md:text-2xl font-black text-slate-800 flex items-center gap-2 pr-16 md:pr-24"><i
                        class="ph-fill ph-wind text-3xl md:text-4xl text-sky-400"></i> Tailwind CSS</div>
            </div>
            <div
                class="pointer-events-none absolute inset-y-0 left-0 w-1/6 bg-gradient-to-r from-[#F8FAFC] to-transparent">
            </div>
            <div
                class="pointer-events-none absolute inset-y-0 right-0 w-1/6 bg-gradient-to-l from-[#F8FAFC] to-transparent">
            </div>
        </div>
    </section>

    <section id="about-dombaku" class="py-24 bg-[#FAFAFA] relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
            <div class="absolute -top-24 -left-24 w-96 h-96 bg-accent/5 rounded-full blur-[120px]"></div>
            <div class="absolute bottom-0 right-0 w-[500px] h-[500px] bg-slate-200/30 rounded-full blur-[150px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16 items-center">

                <div class="lg:col-span-6 relative" data-aos="zoom-out-right">
                    <div class="grid grid-cols-12 gap-4">
                        <div class="col-span-8">
                            <div
                                class="group relative overflow-hidden rounded-[2.5rem] shadow-2xl border-4 border-white transition-transform duration-700 hover:rotate-1">
                                <img src="path-ke-foto-domba-paling-bagus.jpg" alt="Domba"
                                    class="w-full h-[450px] object-cover transition-transform duration-700 group-hover:scale-110"
                                    onerror="this.src='https://images.unsplash.com/photo-1484557985045-7f5d98761a04?q=80&w=600'">
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent opacity-0 group-hover:opacity-100 transition-opacity">
                                </div>
                            </div>
                        </div>

                        <div class="col-span-4 space-y-4 pt-12">
                            <div class="overflow-hidden rounded-[2rem] shadow-xl border-2 border-white">
                                <img src="path-ke-foto-kandang.jpg" alt="Kandang" class="w-full h-40 object-cover"
                                     onerror="this.src='https://images.unsplash.com/photo-1520693678303-42c2448c4356?q=80&w=600'">
                            </div>
                            <div
                                class="bg-white p-5 rounded-[2rem] shadow-xl border border-slate-100 flex flex-col items-center justify-center text-center">
                                <span class="text-3xl font-black text-slate-900 leading-none">100%</span>
                                <span class="text-[10px] text-slate-400 uppercase tracking-[0.2em] mt-2 font-bold">Data
                                    Terenkripsi</span>
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-6 left-12 bg-white/80 backdrop-blur-md p-4 rounded-3xl shadow-lg border border-white/50 flex items-center gap-4 animate-bounce-slow">
                        <div
                            class="w-12 h-12 bg-accent rounded-2xl flex items-center justify-center text-white text-xl">
                            <i class="ph-fill ph-cpu"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-500 font-bold uppercase tracking-widest leading-none">
                                Powered By</p>
                            <p class="text-sm font-black text-slate-900">AI Intelligence</p>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-6" data-aos="fade-left">
                    <header class="mb-10">
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-10 h-[2px] bg-accent"></span>
                            <span class="text-accent font-extrabold text-xs uppercase tracking-[0.3em]">Tentang GoSheep
                            </span>
                        </div>
                        <h2 class="text-5xl lg:text-7xl font-black text-slate-900 mb-6 tracking-tighter leading-[0.9]">
                            Go<span class="text-accent text-outline-thin">Sheep</span>
                        </h2>
                        <p class="text-slate-500 text-lg leading-relaxed max-w-xl">
                            Kami mendefinisikan ulang cara Anda mengelola peternakan. Dengan integrasi <span
                                class="font-bold text-slate-900">Machine Learning</span>, setiap data diubah menjadi
                            keputusan strategis untuk menghasilkan keturunan unggul secara otomatis.
                        </p>
                    </header>

                    <div class="space-y-8 mb-12">
                        <div class="flex gap-6 group">
                            <div
                                class="flex-none w-14 h-14 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-accent group-hover:border-accent/30 transition-all duration-300">
                                <i class="ph-fill ph-chart-bar text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-900 mb-1">Manajemen Ternak Domba</h4>
                                <p class="text-slate-500 text-sm leading-relaxed">Pantau kesehatan, grafik pertumbuhan,
                                    dan rekam medis digital dalam satu dashboard interaktif.</p>
                            </div>
                        </div>

                        <div class="flex gap-6 group">
                            <div
                                class="flex-none w-14 h-14 bg-white shadow-sm border border-slate-100 rounded-2xl flex items-center justify-center text-slate-400 group-hover:text-accent group-hover:border-accent/30 transition-all duration-300">
                                <i class="ph-fill ph-tree-structure text-2xl"></i>
                            </div>
                            <div>
                                <h4 class="text-xl font-bold text-slate-900 mb-1">Rekomendasi Kawin Domba</h4>
                                <p class="text-slate-500 text-sm leading-relaxed">Algoritma <span
                                        class="italic">Tree-based Learning</span> kami bekerja 24/7 untuk menemukan
                                    pasangan genetik terbaik tanpa risiko inbreeding.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center gap-6">
                        <button
                            class="px-10 py-4 bg-[#E8D977] hover:bg-[#D9C85F] text-slate-900 font-black rounded-2xl shadow-[0_15px_30px_-10px_rgba(232,217,119,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95">
                            Pelajari Selengkapnya
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="aplikasi-mobile" class="py-24 bg-white overflow-hidden font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-12 lg:gap-20">

                <div class="w-full lg:w-1/2 flex justify-center relative" data-aos="fade-right">
                    <img src="path-ke-gambar-3-hp.png" alt="Mockup Aplikasi DombaKu"
                        class="w-full max-w-lg object-contain drop-shadow-2xl hover:scale-105 transition-transform duration-700"
                        onerror="this.src='https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-design-system/assets/img/devices/mockup-iphone.png'">
                </div>

                <div class="w-full lg:w-1/2" data-aos="fade-left">

                    <div class="flex items-center gap-3 mb-4">
                        <span class="w-10 h-[2px] bg-accent"></span>
                        <span class="text-accent font-extrabold text-xs uppercase tracking-[0.3em]">Aplikasi
                            Mobile</span>
                    </div>

                    <h2 class="text-4xl md:text-5xl font-bold text-[#142D22] mb-6 tracking-tight leading-tight">
                        DombaKu Mobile untuk Peternak
                    </h2>

                    <p class="text-slate-700 text-lg leading-relaxed mb-8">
                        Kini peternak bisa mencatat data ternak langsung dari lapangan dengan mudah melalui aplikasi
                        <span class="font-bold text-[#142D22]">DombaKu Mobile</span>. Pantau perkembangan, catat
                        kelahiran, dan terima rekomendasi kawin langsung dari genggaman Anda!
                    </p>

                    <ul class="space-y-4 mb-10">
                        <li class="flex items-center gap-3">
                            <i class="ph-fill ph-check-circle text-[#142D22] text-2xl"></i>
                            <span class="text-slate-700 text-[17px] font-medium">Input Data Ternak Langsung</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph-fill ph-check-circle text-[#142D22] text-2xl"></i>
                            <span class="text-slate-700 text-[17px] font-medium">Riwayat dan Kesehatan Domba</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <i class="ph-fill ph-check-circle text-[#142D22] text-2xl"></i>
                            <span class="text-slate-700 text-[17px] font-medium">Notifikasi Jadwal Kawin</span>
                        </li>
                    </ul>

                    <div class="flex items-center gap-6 mt-4">
                        <div
                            class="w-28 h-28 flex-shrink-0 bg-white border-2 border-slate-100 rounded-xl p-1 shadow-sm">
                            <img src="path-ke-qr-code.png" alt="QR Code Download"
                                class="w-full h-full object-contain mix-blend-multiply"
                                onerror="this.src='https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=gosheep'">
                        </div>

                        <div class="flex flex-col gap-3">
                            <p class="text-slate-700 text-[15px]">Scan untuk download:</p>
                            <a href="#"
                                class="inline-flex items-center justify-center gap-2 bg-[#1A875A] hover:bg-[#146b47] text-white px-7 py-3 rounded-full font-bold transition-all duration-300 shadow-lg shadow-[#1A875A]/30 hover:-translate-y-1 hover:shadow-xl w-fit">
                                <i class="ph-bold ph-download-simple text-xl"></i>
                                Download APK
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>

    <section id="layanan" class="py-24 bg-[#FAFAFA] font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mx-auto mb-24 max-w-2xl" data-aos="fade-up">
                <p
                    class="inline-block bg-white text-[#10b981] font-bold tracking-widest uppercase text-sm px-4 py-2 rounded-full mb-4 shadow-sm border border-emerald-50">
                    Layanan Kami
                </p>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-[#142D22] leading-tight">
                    Layanan Untuk Manajemen Ternak Domba
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">

                <div class="relative mt-14 group cursor-pointer" data-aos="fade-up" data-aos-delay="100">

                    <div
                        class="absolute -top-14 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full border-[6px] border-white overflow-hidden z-30 shadow-md transition-transform duration-500 group-hover:scale-110 bg-slate-100">
                        <img src="{{ asset('page/img/service-1.jpg') }}" alt="Manajemen Data"
                            class="w-full h-full object-cover">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden h-full min-h-[400px]">

                        <div
                            class="relative z-10 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center transition-opacity duration-500 group-hover:opacity-0">
                            <h5 class="text-[1.35rem] font-bold text-[#142D22] mb-4">Manajemen Data Ternak</h5>
                            <p class="text-slate-600 text-[15px] leading-relaxed mb-8 flex-grow">
                                Kami menyediakan platform untuk pengelolaan data ternak secara efisien, termasuk
                                informasi genetik, kesehatan, dan riwayat perkawinan ternak Anda.
                            </p>
                            <button
                                class="w-12 h-12 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-[#10b981] transition-transform hover:scale-110">
                                <i class="ph-bold ph-caret-double-right text-xl"></i>
                            </button>
                        </div>

                        <div
                            class="absolute inset-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                            <img src="{{ asset('page/img/service-1.jpg') }}" alt="Background Layanan 1"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#142D22]/80 "></div>

                            <div class="relative z-30 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center">
                                <h5 class="text-[1.35rem] font-bold text-white mb-4">Manajemen Data Ternak</h5>
                                <p class="text-gray-200 text-[15px] leading-relaxed mb-8 flex-grow">
                                    Kami menyediakan platform untuk pengelolaan data ternak secara efisien, termasuk
                                    informasi genetik, kesehatan, dan riwayat perkawinan ternak Anda.
                                </p>
                                <button
                                    class="w-12 h-12 rounded-full bg-[#10b981] shadow-lg flex items-center justify-center text-white transition-transform hover:scale-110">
                                    <i class="ph-bold ph-caret-double-right text-xl"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="relative mt-14 group cursor-pointer" data-aos="fade-up" data-aos-delay="200">

                    <div
                        class="absolute -top-14 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full border-[6px] border-white overflow-hidden z-30 shadow-md transition-transform duration-500 group-hover:scale-110 bg-slate-100">
                        <img src="{{ asset('page/img/service-2.jpg') }}" alt="Rekomendasi Pasangan"
                            class="w-full h-full object-cover">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden h-full min-h-[400px]">

                        <div
                            class="relative z-10 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center transition-opacity duration-500 group-hover:opacity-0">
                            <h5 class="text-[1.35rem] font-bold text-[#142D22] mb-4">Rekomendasi Pasangan Kawin</h5>
                            <p class="text-slate-600 text-[15px] leading-relaxed mb-8 flex-grow">
                                Kami memberikan rekomendasi pasangan kawin yang optimal, menghindari inbreeding dengan
                                mempertimbangkan faktor genetik dan kesehatan ternak.
                            </p>
                            <button
                                class="w-12 h-12 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-[#10b981] transition-transform hover:scale-110">
                                <i class="ph-bold ph-caret-double-right text-xl"></i>
                            </button>
                        </div>

                        <div
                            class="absolute inset-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                            <img src="{{ asset('page/img/service-2.jpg') }}" alt="Background Layanan 2"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#142D22]/80 "></div>

                            <div class="relative z-30 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center">
                                <h5 class="text-[1.35rem] font-bold text-white mb-4">Rekomendasi Pasangan Kawin</h5>
                                <p class="text-gray-200 text-[15px] leading-relaxed mb-8 flex-grow">
                                    Kami memberikan rekomendasi pasangan kawin yang optimal, menghindari inbreeding
                                    dengan mempertimbangkan faktor genetik dan kesehatan ternak.
                                </p>
                                <button
                                    class="w-12 h-12 rounded-full bg-[#10b981] shadow-lg flex items-center justify-center text-white transition-transform hover:scale-110">
                                    <i class="ph-bold ph-caret-double-right text-xl"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="relative mt-14 group cursor-pointer" data-aos="fade-up" data-aos-delay="300">

                    <div
                        class="absolute -top-14 left-1/2 -translate-x-1/2 w-28 h-28 rounded-full border-[6px] border-white overflow-hidden z-30 shadow-md transition-transform duration-500 group-hover:scale-110 bg-slate-100">
                        <img src="{{ asset('page/img/service-1.jpg') }}" alt="Laporan Data Ternak" class="w-full h-full object-cover">
                    </div>

                    <div
                        class="relative bg-white rounded-2xl shadow-[0_10px_40px_rgba(0,0,0,0.06)] overflow-hidden h-full min-h-[400px]">

                        <div
                            class="relative z-10 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center transition-opacity duration-500 group-hover:opacity-0">
                            <h5 class="text-[1.35rem] font-bold text-[#142D22] mb-4">Laporan Data Ternak</h5>
                            <p class="text-slate-600 text-[15px] leading-relaxed mb-8 flex-grow">
                                Kami menyediakan laporan lengkap mengenai jumlah domba berdasarkan umur, jenis kelamin,
                                kelahiran, dan bulan lahir dalam bentuk chart.
                            </p>
                            <button
                                class="w-12 h-12 rounded-full bg-white shadow-md border border-slate-100 flex items-center justify-center text-[#10b981] transition-transform hover:scale-110">
                                <i class="ph-bold ph-caret-double-right text-xl"></i>
                            </button>
                        </div>

                        <div
                            class="absolute inset-0 z-20 translate-y-full group-hover:translate-y-0 transition-transform duration-500 ease-in-out">
                            <img src="{{ asset('page/img/service-1.jpg') }}" alt="Background Layanan 3"
                                class="absolute inset-0 w-full h-full object-cover">
                            <div class="absolute inset-0 bg-[#142D22]/80 "></div>

                            <div class="relative z-30 px-8 pb-10 pt-20 h-full flex flex-col items-center text-center">
                                <h5 class="text-[1.35rem] font-bold text-white mb-4">Laporan Data Ternak</h5>
                                <p class="text-gray-200 text-[15px] leading-relaxed mb-8 flex-grow">
                                    Kami menyediakan laporan lengkap mengenai jumlah domba berdasarkan umur, jenis
                                    kelamin, kelahiran, dan bulan lahir dalam bentuk chart.
                                </p>
                                <button
                                    class="w-12 h-12 rounded-full bg-[#10b981] shadow-lg flex items-center justify-center text-white transition-transform hover:scale-110">
                                    <i class="ph-bold ph-caret-double-right text-xl"></i>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </section>

    <section id="galeri" class="py-24 bg-white font-sans">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col items-center text-center max-w-3xl mx-auto mb-16" data-aos="fade-up">
                <div class="flex items-center justify-center gap-4 mb-4">
                    <div class="h-[2px] w-10 bg-[#10b981]"></div>
                    <span class="text-[#10b981] text-[13px] font-bold uppercase tracking-[0.2em]">Galeri
                        Peternakan</span>
                    <div class="h-[2px] w-10 bg-[#10b981]"></div>
                </div>

                <h2 class="text-4xl md:text-5xl font-black text-[#142D22] tracking-tight leading-tight mb-6">
                    Melihat Lebih Dekat<br>Aktivitas DombaKu.
                </h2>
                <p class="text-slate-500 text-lg leading-relaxed">
                    Dokumentasi fasilitas kandang, kualitas domba, hingga penerapan teknologi digital di lapangan.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

                <div class="relative group rounded-2xl overflow-hidden h-64" data-aos="fade-up" data-aos-delay="100">
                    <img src="img/image copy.png" alt="Kandang Utama"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#142D22]/90 via-[#142D22]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 p-5 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <p class="text-[#10b981] text-xs font-bold tracking-widest uppercase mb-1">Fasilitas</p>
                        <h4 class="text-white font-bold text-lg">Kandang Utama</h4>
                    </div>
                </div>

                <div class="relative group rounded-2xl overflow-hidden h-64" data-aos="fade-up" data-aos-delay="200">
                    <img src="https://images.unsplash.com/photo-1484557985045-7f5d98761a04?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Domba Garut"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#142D22]/90 via-[#142D22]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 p-5 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <p class="text-[#10b981] text-xs font-bold tracking-widest uppercase mb-1">Genetik</p>
                        <h4 class="text-white font-bold text-lg">Bibit Domba Unggul</h4>
                    </div>
                </div>

                <div class="relative group rounded-2xl overflow-hidden h-64" data-aos="fade-up" data-aos-delay="300">
                    <img src="https://images.unsplash.com/photo-1520693678303-42c2448c4356?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Pemberian Pakan"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#142D22]/90 via-[#142D22]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 p-5 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <p class="text-[#10b981] text-xs font-bold tracking-widest uppercase mb-1">Perawatan</p>
                        <h4 class="text-white font-bold text-lg">Manajemen Pakan</h4>
                    </div>
                </div>

                <div class="relative group rounded-2xl overflow-hidden h-64" data-aos="fade-up" data-aos-delay="400">
                    <img src="https://images.unsplash.com/photo-1506933603756-244449a79a54?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80"
                        alt="Kesehatan"
                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                    <div
                        class="absolute inset-0 bg-gradient-to-t from-[#142D22]/90 via-[#142D22]/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                    </div>
                    <div
                        class="absolute bottom-0 left-0 p-5 translate-y-4 group-hover:translate-y-0 opacity-0 group-hover:opacity-100 transition-all duration-500">
                        <p class="text-[#10b981] text-xs font-bold tracking-widest uppercase mb-1">Medis</p>
                        <h4 class="text-white font-bold text-lg">Pengecekan Rutin</h4>
                    </div>
                </div>

            </div>

            <div class="mt-16 text-center" data-aos="fade-up" data-aos-delay="600">
                <a href="#"
                    class="inline-flex items-center gap-2 bg-white border-2 border-slate-200 hover:border-[#10b981] text-[#142D22] hover:text-[#10b981] px-8 py-4 rounded-xl font-bold transition-colors duration-300">
                    Lihat Semua Foto <i class="ph-bold ph-arrow-right"></i>
                </a>
            </div>

        </div>
    </section>

</x-layouts.public>
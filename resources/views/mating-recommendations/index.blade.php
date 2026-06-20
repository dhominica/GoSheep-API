<x-layouts.admin>
    <x-slot name="title">Rekomendasi Perkawinan</x-slot>
    <x-slot name="header">Rekomendasi Perkawinan</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif
    @if(session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Sistem Cari Jodoh Domba</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Pilih domba untuk menemukan rekomendasi pasangan
                terbaik agar menghasilkan keturunan yang unggul dan menghindari risiko kawin sedarah.</p>
        </div>
    </div>

    <!-- Split Screen Container -->
    <div x-data="{
        activeTab: 'ewes',
        selectedSheepId: null,
        selectedSheepEartag: '',
        selectedSheepGender: '',
        selectedSheepBreed: '',
        selectedSheepColor: '',
        selectedSheepAge: '',
        selectedSheepStatus: '',
        selectedSheepEBV: null,
        loading: false,
        errorMessage: '',
        recommendations: [],
        showModal: false,
        selectedRec: null,

        selectSheep(id, eartag, gender, breed, color, age, status, is_eligible) {
            if (!is_eligible) return;
            this.selectedSheepId = id;
            this.selectedSheepEartag = eartag;
            this.selectedSheepGender = gender;
            this.selectedSheepBreed = breed;
            this.selectedSheepColor = color;
            this.selectedSheepAge = age;
            this.selectedSheepStatus = status;
            this.loading = true;
            this.errorMessage = '';
            this.recommendations = [];
            this.selectedSheepEBV = null;

            fetch('/mating-recommendations/' + id + '/get', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal memuat rekomendasi.');
                return res.json();
            })
            .then(res => {
                if (res.success) {
                    this.selectedSheepEBV = res.data.selected_sheep;
                    this.recommendations = res.data.recommendations || [];
                } else {
                    this.selectedSheepEBV = res.data.selected_sheep;
                    this.recommendations = [];
                    this.errorMessage = res.message || 'Tidak ada rekomendasi yang memenuhi syarat.';
                }
            })
            .catch(err => {
                this.errorMessage = err.message || 'Terjadi kesalahan saat menghubungi server.';
            })
            .finally(() => {
                this.loading = false;
                this.$nextTick(() => {
                    if (window.lucide) {
                        window.lucide.createIcons();
                    }
                });
            });
        }
    }" class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

        <!-- SISI KIRI: Daftar Domba Pilihan (Col-span: 4) -->
        <div
            class="lg:col-span-4 flex flex-col bg-white rounded-3xl border border-slate-100 shadow-sm p-5 h-[calc(100vh-210px)] min-h-[500px]">
            <div class="mb-4">
                <h3 class="text-sm font-black text-slate-800 tracking-wide uppercase">Pilih Domba Utama</h3>
                <p class="text-[10px] text-slate-400 font-bold mt-1">Klik domba berstatus "Siap Kawin" di bawah untuk
                    dicarikan jodohnya.</p>
            </div>

            <!-- Tab Controls -->
            <div class="flex p-1 bg-slate-100 rounded-2xl gap-1">
                <button @click="activeTab = 'ewes'"
                    :class="activeTab === 'ewes' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                    class="flex-1 py-2.5 text-xs font-black rounded-xl transition-all duration-200">
                    Betina (Indukan)
                </button>
                <button @click="activeTab = 'rams'"
                    :class="activeTab === 'rams' ? 'bg-white text-slate-800 shadow-sm' : 'text-slate-500 hover:text-slate-800'"
                    class="flex-1 py-2.5 text-xs font-black rounded-xl transition-all duration-200">
                    Jantan (Pejantan)
                </button>
            </div>

            <!-- List Sheep (Scrollable) -->
            <div class="flex-1 overflow-y-auto mt-4 space-y-2.5 pr-1.5 scrollbar-thin">

                <!-- Tab Betina -->
                <div x-show="activeTab === 'ewes'" class="space-y-2.5">
                    @foreach($ewes as $sheep)
                        <div @click="selectSheep({{ $sheep->id }}, '{{ $sheep->eartag }}', '{{ $sheep->gender }}', '{{ $sheep->breed?->name }}', '{{ $sheep->eartag_color }}', '{{ round($sheep->age_days / 30, 1) }} bln', '{{ $sheep->breeding_status }}', {{ $sheep->is_eligible ? 'true' : 'false' }})"
                            :class="{
                                    'border-blue-500 bg-blue-50/45 ring-1 ring-blue-500/20': selectedSheepId === {{ $sheep->id }},
                                    'border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 cursor-pointer': {{ $sheep->is_eligible ? 'true' : 'false' }} && selectedSheepId !== {{ $sheep->id }},
                                    'bg-slate-50/50 border-slate-100/70 opacity-60 cursor-not-allowed': !{{ $sheep->is_eligible ? 'true' : 'false' }}
                                }"
                            class="p-3.5 border-2 rounded-2xl transition-all duration-300 flex items-center justify-between animate-fade-in">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8.5 h-8.5 rounded-xl flex items-center justify-center font-bold text-white shadow-sm border border-white shrink-0"
                                    style="background-color: {{ strtolower($sheep->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($sheep->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($sheep->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($sheep->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                </div>
                                <div class="truncate">
                                    <div class="font-black text-slate-800 text-sm tracking-tight"
                                        x-text="'{{ $sheep->eartag }}'"></div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-0.5 truncate">Jenis:
                                        {{ $sheep->breed?->name ?? 'N/A' }} • {{ round($sheep->age_days / 30, 1) }} bulan
                                    </div>
                                </div>
                            </div>

                            <!-- Badges status -->
                            <div class="shrink-0">
                                @if(!$sheep->is_eligible)
                                    <span
                                        class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-lg border {{ $sheep->breeding_status === 'Sedang Bunting' ? 'bg-amber-50 text-amber-800 border-amber-200' : ($sheep->breeding_status === 'Proses Kawin' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                        {{ $sheep->breeding_status }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Siap Kawin
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Tab Jantan -->
                <div x-show="activeTab === 'rams'" class="space-y-2.5" x-cloak>
                    @foreach($rams as $sheep)
                        <div @click="selectSheep({{ $sheep->id }}, '{{ $sheep->eartag }}', '{{ $sheep->gender }}', '{{ $sheep->breed?->name }}', '{{ $sheep->eartag_color }}', '{{ round($sheep->age_days / 30, 1) }} bln', '{{ $sheep->breeding_status }}', {{ $sheep->is_eligible ? 'true' : 'false' }})"
                            :class="{
                                    'border-blue-500 bg-blue-50/45 ring-1 ring-blue-500/20': selectedSheepId === {{ $sheep->id }},
                                    'border-slate-100 hover:border-slate-200 hover:bg-slate-50/50 cursor-pointer': {{ $sheep->is_eligible ? 'true' : 'false' }} && selectedSheepId !== {{ $sheep->id }},
                                    'bg-slate-50/50 border-slate-100/70 opacity-60 cursor-not-allowed': !{{ $sheep->is_eligible ? 'true' : 'false' }}
                                }"
                            class="p-3.5 border-2 rounded-2xl transition-all duration-300 flex items-center justify-between animate-fade-in">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8.5 h-8.5 rounded-xl flex items-center justify-center font-bold text-white shadow-sm border border-white shrink-0"
                                    style="background-color: {{ strtolower($sheep->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($sheep->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($sheep->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($sheep->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                    <i data-lucide="tag" class="w-4 h-4"></i>
                                </div>
                                <div class="truncate">
                                    <div class="font-black text-slate-800 text-sm tracking-tight"
                                        x-text="'{{ $sheep->eartag }}'"></div>
                                    <div class="text-[10px] text-slate-400 font-bold mt-0.5 truncate">Jenis:
                                        {{ $sheep->breed?->name ?? 'N/A' }} • {{ round($sheep->age_days / 30, 1) }} bulan
                                    </div>
                                </div>
                            </div>

                            <!-- Badges status -->
                            <div class="shrink-0">
                                @if(!$sheep->is_eligible)
                                    <span
                                        class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-lg border {{ $sheep->breeding_status === 'Sedang Bunting' ? 'bg-amber-50 text-amber-800 border-amber-200' : ($sheep->breeding_status === 'Proses Kawin' ? 'bg-indigo-50 text-indigo-700 border-indigo-200' : 'bg-rose-50 text-rose-700 border-rose-200') }}">
                                        {{ $sheep->breeding_status }}
                                    </span>
                                @else
                                    <span
                                        class="inline-flex px-2.5 py-1 text-[9px] font-black uppercase tracking-wider rounded-lg bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Siap Kawin
                                    </span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </div>

        <!-- SISI KANAN: Hasil Analisis & Rekomendasi (Col-span: 8) -->
        <div class="lg:col-span-8 flex flex-col h-[calc(100vh-210px)] min-h-[500px]">

            <!-- 1. Placeholder State (Jika belum memilih domba) -->
            <div x-show="!selectedSheepId"
                class="flex-1 flex flex-col items-center justify-center bg-white rounded-3xl border border-slate-100 shadow-sm p-8 text-center transition-all duration-300">
                <div class="w-20 h-20 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center mb-4">
                    <i data-lucide="git-merge" class="w-10 h-10"></i>
                </div>
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Hasil Pencarian Pasangan</h3>
                <p class="text-sm text-slate-400 font-semibold max-w-sm mt-2">Silakan klik salah satu domba dengan
                    status "Siap Kawin" di panel sebelah kiri untuk mencarikan jodoh terbaiknya.</p>
            </div>

            <!-- 2. Loading State (Sedang Memproses data) -->
            <div x-show="loading"
                class="flex-1 flex flex-col items-center justify-center bg-white rounded-3xl border border-slate-100 shadow-sm p-8 text-center transition-all duration-300"
                x-cloak>
                <div class="relative w-16 h-16 mb-4">
                    <div class="w-16 h-16 border-4 border-blue-100 border-t-blue-600 rounded-full animate-spin"></div>
                </div>
                <h3 class="text-base font-black text-slate-800">Sedang Menganalisis Jodoh Terbaik...</h3>
                <p class="text-xs text-slate-400 font-semibold mt-1">Sistem sedang memeriksa silsilah keluarga domba
                    untuk mencegah kawin sedarah dan menghitung potensi sifat unggul anaknya.</p>
            </div>

            <!-- 3. Loaded State (Data Rekomendasi Berhasil Dimuat) -->
            <div x-show="selectedSheepId && !loading" class="flex-1 flex flex-col min-h-0 space-y-6" x-cloak>

                <!-- Detail Domba Utama -->
                <div
                    class="bg-gradient-to-r from-slate-900 to-slate-800 rounded-3xl shadow-sm p-6 text-white shrink-0 relative overflow-hidden transition-all duration-300">
                    <div class="absolute -right-6 -bottom-6 w-32 h-32 bg-white/5 rounded-full pointer-events-none">
                    </div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center font-bold text-white shadow-md shrink-0 border-2 border-white/20 transition-all duration-300"
                                :style="'background-color: ' + (selectedSheepColor.toLowerCase() === 'yellow' ? '#eab308' : (selectedSheepColor.toLowerCase() === 'red' ? '#ef4444' : (selectedSheepColor.toLowerCase() === 'blue' ? '#3b82f6' : (selectedSheepColor.toLowerCase() === 'green' ? '#22c55e' : '#94a3b8'))))">
                                <i data-lucide="tag" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <h4 class="text-xl font-black tracking-tight" x-text="selectedSheepEartag"></h4>
                                    <span
                                        :class="selectedSheepGender === 'female' ? 'bg-rose-500/20 text-rose-300' : 'bg-blue-500/20 text-blue-300'"
                                        class="px-2.5 py-0.5 text-[9px] font-black uppercase tracking-wider rounded-md"
                                        x-text="selectedSheepGender === 'female' ? 'Betina (Indukan)' : 'Jantan (Pejantan)'"></span>
                                </div>
                                <p class="text-xs text-slate-300 font-medium mt-1"
                                    x-text="'Jenis: ' + selectedSheepBreed + ' • Umur: ' + selectedSheepAge"></p>
                            </div>
                        </div>

                        <!-- Panel Nilai EBV Domba Terpilih -->
                        <div x-show="selectedSheepEBV" class="flex gap-6 sm:border-l sm:border-white/10 sm:pl-6">
                            <div class="text-center">
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Nilai
                                    Genetik Bobot</div>
                                <div class="text-sm font-black mt-1 text-emerald-400"
                                    x-text="selectedSheepEBV && selectedSheepEBV.EBV_Bobot !== null ? (selectedSheepEBV.EBV_Bobot >= 0 ? '+' : '') + Number(selectedSheepEBV.EBV_Bobot).toFixed(4) : '-'">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Nilai
                                    Genetik Tumbuh</div>
                                <div class="text-sm font-black mt-1 text-emerald-400"
                                    x-text="selectedSheepEBV && selectedSheepEBV.EBV_ADG !== null ? (selectedSheepEBV.EBV_ADG >= 0 ? '+' : '') + Number(selectedSheepEBV.EBV_ADG).toFixed(4) : '-'">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Nilai
                                    Genetik Sehat</div>
                                <div class="text-sm font-black mt-1 text-emerald-400"
                                    x-text="selectedSheepEBV && selectedSheepEBV.EBV_Kesehatan !== null ? (selectedSheepEBV.EBV_Kesehatan >= 0 ? '+' : '') + Number(selectedSheepEBV.EBV_Kesehatan).toFixed(4) : '-'">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daftar Pasangan Kandidat (Scrollable) -->
                <div class="flex-1 bg-white rounded-3xl border border-slate-100 shadow-sm p-6 flex flex-col min-h-0">

                    <!-- Panduan Singkat Istilah (Untuk Peternak) -->
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-4 bg-slate-50 border border-slate-100 rounded-2xl p-4 mb-4 shrink-0">
                        <div class="flex gap-2.5">
                            <div
                                class="p-2 rounded-xl bg-blue-50 text-blue-600 h-9 w-9 flex items-center justify-center shrink-0">
                                <i data-lucide="info" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h5 class="text-[11px] font-black text-slate-800 uppercase tracking-wider">Potensi Sifat
                                    Unggul Domba</h5>
                                <p class="text-[9px] text-slate-500 font-semibold leading-relaxed mt-0.5">Angka potensi
                                    fisik (seperti +0.7318) memprediksi seberapa jauh anak domba ini akan lebih baik
                                    daripada rata-rata domba lainnya di peternakan. Nilai positif (+) berarti anak domba
                                    diperkirakan tumbuh lebih bongsor, lebih cepat besar, atau lebih tahan penyakit
                                    dibandingkan domba standar.</p>
                            </div>
                        </div>
                        <div class="flex gap-2.5">
                            <div
                                class="p-2 rounded-xl bg-amber-50 text-amber-600 h-9 w-9 flex items-center justify-center shrink-0">
                                <i data-lucide="heart-off" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <h5 class="text-[11px] font-black text-slate-800 uppercase tracking-wider">Risiko Kawin
                                    Sedarah</h5>
                                <p class="text-[9px] text-slate-500 font-semibold leading-relaxed mt-0.5">Mengukur
                                    persentase kekerabatan antara pejantan dan indukan. Jika nilai <b>di bawah 6.25%</b>
                                    berarti <b>Aman</b>. Jika di atas 6.25% berarti <b>Bahaya</b> karena berisiko
                                    melahirkan anak cacat, kerdil, atau lemah.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-4 shrink-0">
                        <h3 class="text-sm font-black text-slate-800 tracking-wide uppercase">Pilihan Pasangan Terbaik
                        </h3>
                        <span class="inline-flex px-2.5 py-1 text-[10px] font-black bg-blue-50 text-blue-700 rounded-lg"
                            x-text="recommendations.length + ' Pilihan'"></span>
                    </div>

                    <!-- Error Alert -->
                    <div x-show="errorMessage" class="p-4 bg-amber-50 border-l-4 border-amber-500 rounded-r-xl shrink-0"
                        x-cloak>
                        <p class="text-xs font-semibold text-amber-800" x-text="errorMessage"></p>
                    </div>

                    <!-- Candidate list container -->
                    <div class="flex-1 overflow-y-auto space-y-4 pr-1.5 scrollbar-thin">
                        <template x-for="(candidate, index) in recommendations" :key="candidate.sheep.id">
                            <div
                                class="border border-slate-100 hover:border-slate-200 rounded-2xl p-4 transition-all duration-300 hover:shadow-md hover:shadow-slate-100/50 bg-slate-50/20">
                                <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">

                                    <!-- Info Domba Kandidat -->
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-slate-600 bg-slate-100 border border-slate-200 shadow-sm shrink-0">
                                            <i data-lucide="tag" class="w-4.5 h-4.5"></i>
                                        </div>
                                        <div>
                                            <div class="flex items-center gap-1.5">
                                                <span class="font-black text-slate-800 text-sm tracking-tight"
                                                    x-text="candidate.sheep.eartag"></span>
                                                <span
                                                    class="inline-flex px-2 py-0.5 text-[8px] font-black bg-emerald-50 text-emerald-700 rounded border border-emerald-100 uppercase"
                                                    x-text="'Peringkat ' + (index + 1)"></span>
                                            </div>
                                            <p class="text-[10px] text-slate-400 font-bold mt-0.5"
                                                x-text="'Jenis: ' + candidate.sheep.breed"></p>
                                        </div>
                                    </div>

                                    <!-- Hasil AHP & MOORA Scores -->
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 items-center">
                                        <div class="text-center">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                                Kawin Sedarah</p>
                                            <span
                                                :class="candidate.inbreeding_percent > 6.25 ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-emerald-600 bg-emerald-50 border-emerald-100'"
                                                class="inline-block px-2.5 py-0.5 rounded border text-[10px] font-black mt-1 animate-pulse-subtle"
                                                x-text="Number(candidate.inbreeding_percent).toFixed(2) + '% (' + (candidate.inbreeding_percent < 6.25 ? 'Aman' : 'Bahaya') + ')'">
                                            </span>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                                Nilai Genetik</p>
                                            <p class="text-xs font-black text-slate-700 mt-1"
                                                x-text="Number(candidate.scores.genetic).toFixed(4)"></p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">
                                                Nilai Pertumbuhan</p>
                                            <p class="text-xs font-black text-slate-700 mt-1"
                                                x-text="Number(candidate.scores.growth).toFixed(4)"></p>
                                        </div>
                                        <div class="text-center">
                                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-wider">Skor
                                                Kecocokan</p>
                                            <div
                                                class="inline-flex items-center gap-0.5 px-2 py-0.5 bg-emerald-50 text-emerald-700 rounded border border-emerald-100 font-black text-xs mt-1">
                                                <i data-lucide="star"
                                                    class="w-3 h-3 text-emerald-500 fill-emerald-500 shrink-0"></i>
                                                <span x-text="Number(candidate.scores.final).toFixed(2)"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Tombol Aksi -->
                                    <div class="shrink-0 text-right">
                                        <button @click="selectedRec = {
                                                    id: candidate.id || '',
                                                    ewe_id: selectedSheepGender === 'female' ? selectedSheepId : candidate.sheep.id,
                                                    ram_id: selectedSheepGender === 'male' ? selectedSheepId : candidate.sheep.id,
                                                    ewe_eartag: selectedSheepGender === 'female' ? selectedSheepEartag : candidate.sheep.eartag,
                                                    ram_eartag: selectedSheepGender === 'male' ? selectedSheepEartag : candidate.sheep.eartag
                                                }; showModal = true"
                                            class="w-full lg:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold uppercase tracking-wider rounded-xl transition-all shadow-sm shadow-blue-600/20 hover:shadow-blue-600/40 hover:-translate-y-0.5">
                                            <i data-lucide="git-merge" class="w-3.5 h-3.5"></i>
                                            Mulai Kawinkan
                                        </button>
                                    </div>

                                </div>

                                <!-- Prediksi Kualitas Anak Domba (Hasil Warisan Sifat) -->
                                <div
                                    class="bg-white border border-slate-100 p-3.5 rounded-xl mt-4 flex flex-col sm:flex-row sm:items-center justify-between gap-3 animate-fade-in">
                                    <div class="flex items-center gap-2.5">
                                        <div class="p-1.5 rounded-lg bg-emerald-50 text-emerald-600 shrink-0">
                                            <i data-lucide="sparkles" class="w-3.5 h-3.5 fill-emerald-100"></i>
                                        </div>
                                        <div>
                                            <p class="text-[10px] font-black text-slate-800 uppercase tracking-wider">
                                                Prediksi Sifat Unggul Anak</p>
                                            <p class="text-[9px] text-slate-400 font-semibold mt-0.5">Perkiraan kekuatan
                                                fisik/sifat unggul yang diwariskan oleh kedua orang tua ke anak domba.
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex gap-4 self-end sm:self-auto">
                                        <div class="text-center sm:text-right">
                                            <span
                                                class="text-[8px] text-slate-400 font-bold uppercase tracking-wider block">Potensi
                                                Bobot</span>
                                            <span
                                                class="text-xs font-black text-slate-700 mt-0.5 inline-block text-emerald-600"
                                                x-text="(candidate.expected_ebv_offspring.EBV_Bobot >= 0 ? '+' : '') + Number(candidate.expected_ebv_offspring.EBV_Bobot).toFixed(4)"></span>
                                        </div>
                                        <div class="text-center sm:text-right">
                                            <span
                                                class="text-[8px] text-slate-400 font-bold uppercase tracking-wider block">Kecepatan
                                                Tumbuh</span>
                                            <span
                                                class="text-xs font-black text-slate-700 mt-0.5 inline-block text-emerald-600"
                                                x-text="(candidate.expected_ebv_offspring.EBV_ADG >= 0 ? '+' : '') + Number(candidate.expected_ebv_offspring.EBV_ADG).toFixed(4)"></span>
                                        </div>
                                        <div class="text-center sm:text-right">
                                            <span
                                                class="text-[8px] text-slate-400 font-bold uppercase tracking-wider block">Tingkat
                                                Kesehatan</span>
                                            <span
                                                class="text-xs font-black text-slate-700 mt-0.5 inline-block text-emerald-600"
                                                x-text="(candidate.expected_ebv_offspring.EBV_Kesehatan >= 0 ? '+' : '') + Number(candidate.expected_ebv_offspring.EBV_Kesehatan).toFixed(4)"></span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </template>
                    </div>

                </div>

            </div>

        </div>

        <!-- Kawinkan Modal (Modal Persilangan) -->
        <div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
            x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div
                class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-lg overflow-hidden z-10 transform transition-all relative">
                <div class="bg-blue-600 h-1 w-full"></div>
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                            <i data-lucide="git-merge" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight">Masukkan Domba ke Kandang Kawin
                            </h3>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-0.5"
                                x-text="selectedRec ? selectedRec.ewe_eartag + ' & ' + selectedRec.ram_eartag : ''"></p>
                        </div>
                    </div>
                    <button @click="showModal = false"
                        class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>

                <form action="{{ route('mating.store') }}" method="POST" class="p-6">
                    @csrf
                    <!-- Hidden inputs for ID -->
                    <input type="hidden" name="recommendation_id" :value="selectedRec ? selectedRec.id : ''">
                    <input type="hidden" name="ewe_id" :value="selectedRec ? selectedRec.ewe_id : ''">
                    <input type="hidden" name="ram_id" :value="selectedRec ? selectedRec.ram_id : ''">

                    <div class="space-y-5">
                        <div
                            class="bg-slate-50 border border-slate-100 p-4 rounded-xl flex items-center justify-between">
                            <div class="text-center flex-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Betina
                                    (Indukan)</p>
                                <p class="text-sm font-black text-slate-800"
                                    x-text="selectedRec ? selectedRec.ewe_eartag : ''"></p>
                            </div>
                            <div
                                class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center mx-2 border border-slate-100 text-rose-500">
                                <i data-lucide="heart" class="w-3.5 h-3.5 fill-rose-100"></i>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jantan
                                    (Pejantan)</p>
                                <p class="text-sm font-black text-slate-800"
                                    x-text="selectedRec ? selectedRec.ram_eartag : ''"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="mating_date"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal
                                    Mulai (Masuk Kandang) <span class="text-rose-500">*</span></label>
                                <input type="date" name="mating_date" id="mating_date" required
                                    value="{{ date('Y-m-d') }}"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>

                            <div>
                                <label for="end_date"
                                    class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal
                                    Selesai (Pisah Kandang) <span class="text-rose-500">*</span></label>
                                <input type="date" name="end_date" id="end_date" required
                                    value="{{ date('Y-m-d', strtotime('+35 days')) }}"
                                    class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                <p class="text-[10px] font-medium text-slate-400 mt-1.5">* Catatan: Umumnya pejantan dan
                                    indukan dicampur selama 35 hari agar tidak terlewat masa suburnya.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                        <button type="button" @click="showModal = false"
                            class="px-5 py-2.5 text-xs font-bold text-slate-600 uppercase tracking-wider bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 text-xs font-bold text-white uppercase tracking-wider bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-600/20 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Mulai Kawinkan
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</x-layouts.admin>

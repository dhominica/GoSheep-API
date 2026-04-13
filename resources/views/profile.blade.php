<x-layouts.admin>
    <x-slot:title>Profil Saya</x-slot:title>
    <x-slot:header>Pengaturan Akun</x-slot:header>

    @if (session('success'))
        <x-alert title="Pembaruan Berhasil" type="success">
            {{ session('success') }}
        </x-alert>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sidebar Info -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 flex flex-col items-center text-center">
            
            <div class="w-28 h-28 rounded-full bg-gradient-to-tr from-green-500 to-teal-400 flex items-center justify-center font-extrabold text-4xl text-white shadow-xl shadow-green-500/20 mb-5 relative group">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>
            
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">{{ Auth::user()->name }}</h2>
            <p class="text-[11px] font-bold text-green-700 uppercase tracking-widest mt-2 bg-green-50 px-3.5 py-1.5 rounded-lg border border-green-100">{{ Auth::user()->role }} Mode</p>

            <div class="w-full border-t border-slate-100 mt-8 pt-6 space-y-4 text-left">
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <span class="text-slate-500 text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="shield-check" class="w-4 h-4 text-emerald-500"></i>
                        Status Akun
                    </span>
                    <span class="text-emerald-600 text-sm font-bold uppercase">{{ Auth::user()->status }}</span>
                </div>
                <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50">
                    <span class="text-slate-500 text-xs font-bold uppercase tracking-wider flex items-center gap-2">
                        <i data-lucide="calendar" class="w-4 h-4 text-emerald-500"></i>
                        Terdaftar Sejak
                    </span>
                    <span class="text-slate-700 text-sm font-extrabold">{{ Auth::user()->created_at->format('d M Y') }}</span>
                </div>
            </div>
            
        </div>

        <!-- Layout Form Utama -->
        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-100 p-8 relative overflow-hidden">
            <!-- Pola Penghias Belakang Form -->
            <div class="absolute right-0 top-0 w-64 h-64 bg-green-500/5 rounded-full blur-[80px] pointer-events-none"></div>

            <div class="mb-8 border-b border-slate-100 pb-5 relative z-10">
                <h3 class="text-xl font-extrabold text-slate-800 flex items-center gap-2">
                    <i data-lucide="user-cog" class="w-6 h-6 text-green-500"></i>
                    Informasi Dasar
                </h3>
                <p class="text-sm text-slate-500 mt-1 font-medium">Perbarui alamat email dan detail lain dari akun Anda di sini.</p>
            </div>

            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6 relative z-10">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2 ml-1">Nama Lengkap</label>
                        <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-500/10 outline-none transition-all text-sm font-bold text-slate-800 shadow-sm placeholder-slate-300">
                        @error('name') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2 ml-1">Alamat Email</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required
                            class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-green-500 focus:ring-4 focus:ring-green-500/10 outline-none transition-all text-sm font-bold text-slate-800 shadow-sm placeholder-slate-300">
                        @error('email') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="border-t border-slate-100 pt-8 mt-4">
                    <h4 class="text-lg font-extrabold text-slate-800 mb-1 flex items-center gap-2">
                        <i data-lucide="lock" class="w-5 h-5 text-amber-500"></i>
                        Ganti Kata Sandi
                    </h4>
                    <p class="text-xs text-slate-400 font-bold mb-6">Opsional. Kosongkan jika Anda tidak bermaksud mengganti kata sandi utama.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2 ml-1">Sandi Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all text-sm font-bold text-slate-800 shadow-sm placeholder-slate-300">
                            @error('password') <span class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-wider mb-2 ml-1">Konfirmasi Sandi Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi sandi baru"
                                class="w-full px-4 py-3.5 rounded-xl border border-slate-200 bg-slate-50/50 focus:bg-white focus:border-amber-500 focus:ring-4 focus:ring-amber-500/10 outline-none transition-all text-sm font-bold text-slate-800 shadow-sm placeholder-slate-300">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end pt-6 border-t border-slate-100">
                    <button type="submit" class="bg-gradient-to-r from-green-600 to-emerald-500 hover:from-green-500 hover:to-emerald-400 text-white font-extrabold py-3.5 px-8 rounded-xl transition-all shadow-lg shadow-green-500/30 active:scale-95 flex items-center gap-2 border border-green-500">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

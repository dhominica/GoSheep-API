<x-layouts.admin>
    <x-slot name="title">Edit Persilangan</x-slot>
    <x-slot name="header">Edit Persilangan (Mating)</x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-black text-slate-800">Form Edit Persilangan</h2>
                    <p class="text-xs text-slate-500 mt-1">Ubah data jadwal dan hasil persilangan ternak domba.</p>
                </div>
                <a href="{{ route('mating.index') }}"
                    class="p-2 text-slate-400 hover:text-slate-600 bg-slate-50 hover:bg-slate-100 rounded-lg transition-colors">
                    <i data-lucide="arrow-left" class="w-5 h-5"></i>
                </a>
            </div>

            <form action="{{ route('mating.update', $mating->id) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="space-y-6">
                    <!-- Ewe & Ram Info (Readonly) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Domba Betina</label>
                            <input type="text" readonly
                                value="{{ $mating->ewe->eartag ?? 'N/A' }} ({{ $mating->ewe->breed->name ?? 'Lokal' }})"
                                class="w-full bg-slate-100 border border-slate-200 text-slate-500 rounded-xl px-4 py-3 text-sm cursor-not-allowed">
                            <input type="hidden" name="ewe_id" value="{{ $mating->ewe_id }}">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Domba Jantan</label>
                            <input type="text" readonly
                                value="{{ $mating->ram->eartag ?? 'N/A' }} ({{ $mating->ram->breed->name ?? 'Lokal' }})"
                                class="w-full bg-slate-100 border border-slate-200 text-slate-500 rounded-xl px-4 py-3 text-sm cursor-not-allowed">
                            <input type="hidden" name="ram_id" value="{{ $mating->ram_id }}">
                        </div>
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="mating_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Mulai
                                <span class="text-rose-500">*</span></label>
                            <input type="date" name="mating_date" id="mating_date" required
                                value="{{ old('mating_date', $mating->mating_date) }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            @error('mating_date')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="end_date" class="block text-sm font-bold text-slate-700 mb-2">Tanggal Selesai
                                <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" id="end_date" required
                                value="{{ old('end_date', $mating->end_date) }}"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            @error('end_date')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Result section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-6 border-t border-slate-100">
                        <div>
                            <label for="result" class="block text-sm font-bold text-slate-700 mb-2">Hasil
                                Persilangan</label>
                            <select name="result" id="result"
                                class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                                <option value="unknown" {{ old('result', $mating->result) == 'unknown' ? 'selected' : '' }}>Belum Diketahui</option>
                                <option value="pregnant" {{ old('result', $mating->result) == 'pregnant' ? 'selected' : '' }}>Bunting (Pregnant)</option>
                                <option value="not_pregnant" {{ old('result', $mating->result) == 'not_pregnant' ? 'selected' : '' }}>Tidak Bunting</option>
                                <option value="failed" {{ old('result', $mating->result) == 'failed' ? 'selected' : '' }}>
                                    Gagal</option>
                            </select>
                            @error('result')
                                <p class="text-xs text-rose-500 mt-1.5 font-medium">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mt-8 flex items-center justify-end gap-3 pt-6 border-t border-slate-100">
                    <a href="{{ route('mating.index') }}"
                        class="px-5 py-2.5 text-sm font-bold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-bold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-600/20 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                        <i data-lucide="save" class="w-4 h-4"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.admin>

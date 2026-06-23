<x-layouts.admin>
    <x-slot name="title">Edit Data Kehamilan</x-slot>
    <x-slot name="header">Edit Kehamilan</x-slot>

    <div class="mb-6">
        <a href="{{ route('pregnancies.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-500 hover:text-emerald-600 transition-colors">
            <i data-lucide="arrow-left" class="w-4 h-4"></i>
            Kembali ke Daftar Kehamilan
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0">
                <i data-lucide="baby" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="text-lg font-black text-slate-800 tracking-tight">Form Edit Kehamilan</h3>
                <p class="text-xs font-medium text-slate-500 mt-0.5">Perbarui status dan data kehamilan domba.</p>
            </div>
        </div>

        <div class="p-6">
            <form action="{{ route('pregnancies.update', $pregnancy->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Domba Betina</label>
                        <input type="text" value="{{ $pregnancy->ewe->eartag ?? 'N/A' }}" disabled class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 font-medium cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Domba Jantan (Pejantan)</label>
                        <input type="text" value="{{ $pregnancy->matingRecord->ram->eartag ?? 'N/A' }}" disabled class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 font-medium cursor-not-allowed">
                    </div>
                    
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Mulai (Kawin)</label>
                        <input type="text" value="{{ $pregnancy->start_date ? \Carbon\Carbon::parse($pregnancy->start_date)->format('d M Y') : '-' }}" disabled class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-500 font-medium cursor-not-allowed">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Prediksi Lahir</label>
                        <input type="date" name="expected_birth_date" value="{{ old('expected_birth_date', $pregnancy->expected_birth_date ? \Carbon\Carbon::parse($pregnancy->expected_birth_date)->format('Y-m-d') : '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        @error('expected_birth_date')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Status Kehamilan <span class="text-rose-500">*</span></label>
                        <select id="status_select" name="status" required class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                            <option value="ongoing" {{ old('status', $pregnancy->status) === 'ongoing' ? 'selected' : '' }}>Mengandung (Ongoing)</option>
                            <option value="birthed" {{ old('status', $pregnancy->status) === 'birthed' ? 'selected' : '' }}>Telah Lahir (Birthed)</option>
                            <option value="miscarried" {{ old('status', $pregnancy->status) === 'miscarried' ? 'selected' : '' }}>Keguguran (Miscarried)</option>
                        </select>
                        @error('status')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Selesai (Jika Lahir/Keguguran)</label>
                        <input type="date" name="end_date" value="{{ old('end_date', $pregnancy->end_date ? \Carbon\Carbon::parse($pregnancy->end_date)->format('Y-m-d') : '') }}" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none">
                        @error('end_date')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Catatan Tambahan</label>
                        <textarea name="notes" rows="3" class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none" placeholder="Masukkan catatan tambahan jika ada">{{ old('notes', $pregnancy->notes) }}</textarea>
                        @error('notes')
                            <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- ====== BIRTH SECTION (tampil hanya jika status = birthed) ====== --}}
                <div id="birth_section" class="{{ old('status', $pregnancy->status) === 'birthed' ? '' : 'hidden' }}">
                    <div class="border-t border-dashed border-emerald-200 pt-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-9 h-9 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center shrink-0">
                                <i data-lucide="baby" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h4 class="text-sm font-black text-slate-800">Data Kelahiran</h4>
                                <p class="text-xs text-slate-500">Isi data anak yang lahir dari induk ini.</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Total Anak Lahir <span class="text-rose-500">*</span>
                                </label>
                                <input type="number" name="total_lambs" id="total_lambs" min="1"
                                    value="{{ old('total_lambs', $pregnancy->birth->total_lambs ?? '') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none"
                                    placeholder="Masukkan jumlah anak...">
                                @error('total_lambs')
                                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                                    Catatan Kelahiran
                                </label>
                                <input type="text" name="birth_notes"
                                    value="{{ old('birth_notes', $pregnancy->birth->birth_notes ?? '') }}"
                                    class="w-full bg-white border border-slate-200 rounded-xl px-4 py-3 text-sm text-slate-700 font-medium focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none"
                                    placeholder="Contoh: Lahir sehat semua">
                                @error('birth_notes')
                                    <p class="text-rose-500 text-xs mt-1.5 font-medium">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                {{-- ====== END BIRTH SECTION ====== --}}

                <div class="flex items-center justify-end gap-3 pt-6 mt-2 border-t border-slate-100">
                    <a href="{{ route('pregnancies.index') }}" class="px-5 py-2.5 text-sm font-bold text-slate-500 hover:text-slate-700 hover:bg-slate-50 rounded-xl transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-6 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-bold rounded-xl transition-all shadow-sm shadow-emerald-600/20 hover:shadow-emerald-600/40 hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const statusSelect = document.getElementById('status_select');
            const birthSection = document.getElementById('birth_section');
            const totalLambsInput = document.getElementById('total_lambs');

            function toggleBirthSection() {
                if (statusSelect.value === 'birthed') {
                    birthSection.classList.remove('hidden');
                    totalLambsInput.setAttribute('required', 'required');
                } else {
                    birthSection.classList.add('hidden');
                    totalLambsInput.removeAttribute('required');
                }
            }

            // Run on page load
            toggleBirthSection();

            // Run on change
            statusSelect.addEventListener('change', toggleBirthSection);
        });
    </script>
</x-layouts.admin>

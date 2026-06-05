<x-layouts.admin>
    <x-slot name="title">Rekomendasi Perkawinan</x-slot>
    <x-slot name="header">Rekomendasi Perkawinan</x-slot>

    @if(session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif
    @if(session('error'))
        <x-alert type="error" message="{{ session('error') }}" />
    @endif
    @if($errors->any())
        <div class="mb-6 p-4 bg-rose-50 border-l-4 border-rose-500 rounded-r-xl">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-500"></i>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-bold text-rose-800">Terdapat kesalahan:</h3>
                    <ul class="mt-2 text-sm text-rose-700 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
        <div>
            <h2 class="text-2xl font-black text-slate-800 tracking-tight">Sistem Rekomendasi Kawin</h2>
            <p class="text-xs font-semibold text-slate-400 mt-1.5">Pilih pasangan domba berdasarkan kecocokan genetik dan performa untuk hasil optimal.</p>
        </div>
    </div>

    <!-- Main Data Table -->
    <div x-data="{ showModal: false, selectedRec: null }">
        <x-data-table :data="$recommendations" title="Daftar Pasangan Direkomendasikan">
            <x-slot name="header">
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider w-16 text-center">NO.</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DOMBA BETINA</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider">DOMBA JANTAN</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">SKOR KECOCOKAN</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-center">INBREEDING (Koef.)</th>
                <th class="px-6 py-3 text-[10px] font-bold text-slate-500 uppercase tracking-wider text-right">AKSI</th>
            </x-slot>

            @foreach($recommendations as $record)
                <tr class="hover:bg-emerald-50/40 even:bg-slate-50/30 transition-all duration-300">
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium text-slate-400">
                        {{ ($recommendations->currentPage() - 1) * $recommendations->perPage() + $loop->iteration }}
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                                 style="background-color: {{ strtolower($record->ewe->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($record->ewe->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($record->ewe->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($record->ewe->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                <i data-lucide="tag" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-700">
                                    {{ $record->ewe->eartag ?? 'N/A' }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Betina</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-bold text-white shadow-sm shrink-0 border border-white"
                                 style="background-color: {{ strtolower($record->ram->eartag_color ?? '') === 'yellow' ? '#eab308' : (strtolower($record->ram->eartag_color ?? '') === 'red' ? '#ef4444' : (strtolower($record->ram->eartag_color ?? '') === 'blue' ? '#3b82f6' : (strtolower($record->ram->eartag_color ?? '') === 'green' ? '#22c55e' : '#94a3b8'))) }}">
                                <i data-lucide="tag" class="w-4 h-4"></i>
                            </div>
                            <div>
                                <div class="font-bold text-slate-700">
                                    {{ $record->ram->eartag ?? 'N/A' }}
                                </div>
                                <div class="text-[10px] text-slate-400 font-bold uppercase mt-0.5">Jantan</div>
                            </div>
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <div class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-100 font-black text-sm">
                            <i data-lucide="star" class="w-3.5 h-3.5 text-emerald-500 fill-emerald-500"></i>
                            {{ number_format($record->final_score, 2) }}
                        </div>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @php
                            $inbreeding = $record->inbreeding_coefficient * 100;
                            $inbreedingClass = $inbreeding > 6.25 ? 'text-rose-600 bg-rose-50 border-rose-100' : 'text-slate-600 bg-slate-50 border-slate-100';
                        @endphp
                        <span class="inline-flex px-2.5 py-1 rounded-md border text-xs font-bold {{ $inbreedingClass }}">
                            {{ number_format($inbreeding, 2) }}%
                        </span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap text-right font-medium">
                        <button @click="selectedRec = {{ json_encode([
                                'id' => $record->id,
                                'ewe_id' => $record->ewe_id,
                                'ram_id' => $record->ram_id,
                                'ewe_eartag' => $record->ewe->eartag ?? 'N/A',
                                'ram_eartag' => $record->ram->eartag ?? 'N/A'
                            ]) }}; showModal = true" 
                                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold uppercase tracking-wider rounded-lg transition-all shadow-sm shadow-blue-600/20 hover:shadow-blue-600/40 hover:-translate-y-0.5">
                            <i data-lucide="git-merge" class="w-3.5 h-3.5"></i>
                            Kawinkan
                        </button>
                    </td>
                </tr>
            @endforeach
        </x-data-table>

        <!-- Kawinkan Modal -->
        <div x-show="showModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4 overflow-y-auto"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0">
             
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="showModal = false"></div>

            <!-- Modal Content -->
            <div class="bg-white rounded-3xl shadow-[0_20px_50px_rgba(0,0,0,0.15)] w-full max-w-lg overflow-hidden z-10 transform transition-all relative">
                <div class="bg-blue-600 h-1 w-full"></div>
                <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 rounded-xl bg-blue-50 text-blue-600">
                            <i data-lucide="git-merge" class="w-4 h-4"></i>
                        </div>
                        <div>
                            <h3 class="text-sm font-bold text-slate-800 tracking-tight">Proses Persilangan Baru</h3>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mt-0.5" x-text="selectedRec ? selectedRec.ewe_eartag + ' & ' + selectedRec.ram_eartag : ''"></p>
                        </div>
                    </div>
                    <button @click="showModal = false" class="p-1.5 text-slate-400 hover:text-slate-600 rounded-lg hover:bg-slate-100 transition-colors">
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
                        <div class="bg-slate-50 border border-slate-100 p-4 rounded-xl flex items-center justify-between">
                            <div class="text-center flex-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Betina</p>
                                <p class="text-sm font-black text-slate-800" x-text="selectedRec ? selectedRec.ewe_eartag : ''"></p>
                            </div>
                            <div class="w-8 h-8 rounded-full bg-white shadow-sm flex items-center justify-center mx-2 border border-slate-100 text-rose-500">
                                <i data-lucide="heart" class="w-3.5 h-3.5 fill-rose-100"></i>
                            </div>
                            <div class="text-center flex-1">
                                <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Jantan</p>
                                <p class="text-sm font-black text-slate-800" x-text="selectedRec ? selectedRec.ram_eartag : ''"></p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-5">
                            <div>
                                <label for="mating_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Mulai (Masuk Kandang) <span class="text-rose-500">*</span></label>
                                <input type="date" name="mating_date" id="mating_date" required value="{{ date('Y-m-d') }}"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                            </div>

                            <div>
                                <label for="end_date" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Tanggal Selesai (Pisah Kandang) <span class="text-rose-500">*</span></label>
                                <input type="date" name="end_date" id="end_date" required value="{{ date('Y-m-d', strtotime('+35 days')) }}"
                                       class="w-full bg-slate-50 border border-slate-200 text-slate-700 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all outline-none">
                                <p class="text-[10px] font-medium text-slate-400 mt-1.5">* Default: 35 hari siklus estrus.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex items-center justify-end gap-3 pt-5 border-t border-slate-100">
                        <button type="button" @click="showModal = false" class="px-5 py-2.5 text-xs font-bold text-slate-600 uppercase tracking-wider bg-slate-100 hover:bg-slate-200 rounded-xl transition-colors">
                            Batal
                        </button>
                        <button type="submit" class="px-5 py-2.5 text-xs font-bold text-white uppercase tracking-wider bg-blue-600 hover:bg-blue-700 rounded-xl shadow-sm shadow-blue-600/20 transition-all hover:-translate-y-0.5 flex items-center gap-2">
                            <i data-lucide="check" class="w-4 h-4"></i>
                            Konfirmasi Persilangan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.admin>

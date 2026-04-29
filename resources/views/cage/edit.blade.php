<x-layouts.admin>
    <x-slot name="title">Edit Data Kandang</x-slot>
    <x-slot name="header">Edit Kandang</x-slot>

    <x-form-card action="{{ route('cage.update', $cage->id) }}" method="PUT" title="Edit Informasi Kandang" badgeText="Edit Data"
        color="emerald">

        <x-slot:badgeIcon>
            <i data-lucide="edit-3" class="w-3.5 h-3.5 mt-[-1px]"></i>
        </x-slot:badgeIcon>

        <x-slot:description>
            Perbarui data informasi kandang. Perhatikan kapasitas kandang jika ada domba di dalamnya.
        </x-slot:description>

        <x-slot:cornerIcon>
            <i data-lucide="home" class="w-7 h-7 text-emerald-400 shadow-emerald-400"></i>
        </x-slot:cornerIcon>

        <!-- Section Title -->
        <x-form-section title="Informasi Kandang" color="emerald">
            <i data-lucide="info" class="w-5 h-5"></i>
        </x-form-section>

        <!-- Name Component -->
        <div class="col-span-1 md:col-span-2">
            <x-form-input name="name" label="Nama / Kode Kandang" value="{{ old('name', $cage->name) }}" placeholder="Cth: Kandang A - Blok Utara" :required="true" color="emerald">
                <x-slot:icon><i data-lucide="type" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Section Title 2 -->
        <x-form-section title="Pengaturan Kapasitas" color="blue" :marginTop="true">
            <i data-lucide="sliders" class="w-5 h-5"></i>
        </x-form-section>

        <!-- Max Capacity Component -->
        <div class="col-span-1">
            <x-form-input name="max_capacity" type="number" label="Kapasitas Maksimal (Ekor)" value="{{ old('max_capacity', $cage->max_capacity) }}" placeholder="Cth: 50" :required="true" color="blue">
                <x-slot:icon><i data-lucide="maximize" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Current Capacity Component -->
        <div class="col-span-1">
            <x-form-input name="current_capacity" type="number" value="{{ old('current_capacity', $cage->current_capacity) }}" label="Jumlah Saat Ini (Ekor)" placeholder="Cth: 0" :required="true" color="blue">
                <x-slot:icon><i data-lucide="users" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <x-slot:actions>
            <x-btn href="{{ route('cage.index') }}" color="slate">
                Batal
            </x-btn>
            <x-btn type="submit" color="emerald">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Perubahan
            </x-btn>
        </x-slot:actions>
    </x-form-card>
</x-layouts.admin>

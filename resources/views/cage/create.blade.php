<x-layouts.admin>
    <x-slot name="title">Tambah Kandang Baru</x-slot>
    <x-slot name="header">Kandang Baru</x-slot>

    <x-form-card action="{{ route('cage.store') }}" title="Registrasi Kandang" badgeText="Data Baru"
        color="emerald">

        <x-slot:badgeIcon>
            <i data-lucide="plus-circle" class="w-3.5 h-3.5 mt-[-1px]"></i>
        </x-slot:badgeIcon>

        <x-slot:description>
            Masukkan informasi detail kandang baru yang akan digunakan untuk menampung domba.
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
            <x-form-input name="name" label="Nama / Kode Kandang" placeholder="Cth: Kandang A - Blok Utara" :required="true" color="emerald">
                <x-slot:icon><i data-lucide="type" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Section Title 2 -->
        <x-form-section title="Pengaturan Kapasitas" color="blue" :marginTop="true">
            <i data-lucide="sliders" class="w-5 h-5"></i>
        </x-form-section>

        <!-- Max Capacity Component -->
        <div class="col-span-1">
            <x-form-input name="max_capacity" type="number" label="Kapasitas Maksimal (Ekor)" placeholder="Cth: 50" :required="true" color="blue">
                <x-slot:icon><i data-lucide="maximize" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Current Capacity Component (Read Only in UI but passed as 0 usually, or user can input if migrating) -->
        <div class="col-span-1">
            <x-form-input name="current_capacity" type="number" value="0" label="Jumlah Saat Ini (Ekor)" placeholder="Cth: 0" :required="true" color="blue">
                <x-slot:icon><i data-lucide="users" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <x-slot:actions>
            <x-btn href="{{ route('cage.index') }}" color="slate">
                Batal
            </x-btn>
            <x-btn type="submit" color="emerald">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Data Kandang
            </x-btn>
        </x-slot:actions>
    </x-form-card>
</x-layouts.admin>

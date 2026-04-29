<x-layouts.admin>
    <x-slot name="title">Tambah Domba Baru</x-slot>
    <x-slot name="header">Domba Baru</x-slot>

    <x-form-card action="{{ route('sheep.store') }}" title="Registrasi Domba" badgeText="Data Baru"
        color="emerald">

        <x-slot:badgeIcon>
            <i data-lucide="plus-circle" class="w-3.5 h-3.5 mt-[-1px]"></i>
        </x-slot:badgeIcon>

        <x-slot:description>
            Masukkan data detail domba baru ke dalam sistem. Pastikan Eartag unik dan belum pernah didaftarkan.
        </x-slot:description>

        <x-slot:cornerIcon>
            <i data-lucide="box" class="w-7 h-7 text-emerald-400 shadow-emerald-400"></i>
        </x-slot:cornerIcon>

        <!-- Section Title -->
        <x-form-section title="Informasi Utama" color="emerald">
            <i data-lucide="tag" class="w-5 h-5"></i>
        </x-form-section>

        <!-- Eartag Component -->
        <div class="col-span-1">
            <x-form-input name="eartag" label="ID Eartag" placeholder="Cth: ET001" :required="true" color="emerald">
                <x-slot:icon><i data-lucide="hash" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Eartag Color Component -->
        <div class="col-span-1">
            <x-form-select name="eartag_color" label="Warna Eartag" color="emerald" :required="true">
                <x-slot:icon><i data-lucide="palette" class="w-5 h-5"></i></x-slot:icon>
                <option value="yellow" {{ old('eartag_color') == 'yellow' ? 'selected' : '' }}>Kuning</option>
                <option value="red" {{ old('eartag_color') == 'red' ? 'selected' : '' }}>Merah</option>
                <option value="blue" {{ old('eartag_color') == 'blue' ? 'selected' : '' }}>Biru</option>
                <option value="green" {{ old('eartag_color') == 'green' ? 'selected' : '' }}>Hijau</option>
            </x-form-select>
        </div>

        <!-- Gender Component -->
        <div class="col-span-1">
            <x-form-select name="gender" label="Jenis Kelamin" color="emerald" :required="true">
                <x-slot:icon><i data-lucide="users" class="w-5 h-5"></i></x-slot:icon>
                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Jantan</option>
                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Betina</option>
            </x-form-select>
        </div>

        <!-- Birth Date Component -->
        <div class="col-span-1">
            <x-form-input name="birth_date" type="date" label="Tanggal Lahir" placeholder="" :required="true" color="emerald">
                <x-slot:icon><i data-lucide="calendar" class="w-5 h-5"></i></x-slot:icon>
            </x-form-input>
        </div>

        <!-- Status Component -->
        <div class="col-span-1 md:col-span-2">
            <x-form-select name="status" label="Status Domba" color="emerald" :required="true">
                <x-slot:icon><i data-lucide="activity" class="w-5 h-5"></i></x-slot:icon>
                <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Aktif</option>
                <option value="sold" {{ old('status') == 'sold' ? 'selected' : '' }}>Terjual</option>
                <option value="dead" {{ old('status') == 'dead' ? 'selected' : '' }}>Mati</option>
            </x-form-select>
        </div>

        <!-- Section Title 2 -->
        <x-form-section title="Data Genetik & Lokasi" color="blue" :marginTop="true">
            <i data-lucide="dna" class="w-5 h-5"></i>
        </x-form-section>

        <!-- Breed Component -->
        <div class="col-span-1">
            <x-form-select name="breed_id" label="Jenis Domba (Breed)" color="blue">
                <x-slot:icon><i data-lucide="git-merge" class="w-5 h-5"></i></x-slot:icon>
                <option value="">Pilih Jenis</option>
                @foreach($breeds as $breed)
                    <option value="{{ $breed->id }}" {{ old('breed_id') == $breed->id ? 'selected' : '' }}>{{ $breed->name }}</option>
                @endforeach
            </x-form-select>
        </div>

        <!-- Cage Component -->
        <div class="col-span-1">
            <x-form-select name="cage_id" label="Kandang" color="blue">
                <x-slot:icon><i data-lucide="home" class="w-5 h-5"></i></x-slot:icon>
                <option value="">Pilih Kandang</option>
                @foreach($cages as $cage)
                    <option value="{{ $cage->id }}" {{ old('cage_id') == $cage->id ? 'selected' : '' }}>{{ $cage->name }}</option>
                @endforeach
            </x-form-select>
        </div>

        <!-- Sire Component -->
        <div class="col-span-1">
            <x-form-select name="sire_id" label="Bapak (Sire)" color="blue">
                <x-slot:icon><i data-lucide="mars" class="w-5 h-5"></i></x-slot:icon>
                <option value="">Pilih Bapak (Opsional)</option>
                @foreach($sires as $sire)
                    <option value="{{ $sire->id }}" {{ old('sire_id') == $sire->id ? 'selected' : '' }}>{{ $sire->eartag }}</option>
                @endforeach
            </x-form-select>
        </div>

        <!-- Dam Component -->
        <div class="col-span-1">
            <x-form-select name="dam_id" label="Induk (Dam)" color="blue">
                <x-slot:icon><i data-lucide="venus" class="w-5 h-5"></i></x-slot:icon>
                <option value="">Pilih Induk (Opsional)</option>
                @foreach($dams as $dam)
                    <option value="{{ $dam->id }}" {{ old('dam_id') == $dam->id ? 'selected' : '' }}>{{ $dam->eartag }}</option>
                @endforeach
            </x-form-select>
        </div>

        <x-slot:actions>
            <x-btn href="{{ route('sheep.index') }}" color="slate">
                Batal
            </x-btn>
            <x-btn type="submit" color="emerald">
                <i data-lucide="save" class="w-5 h-5"></i>
                Simpan Data Domba
            </x-btn>
        </x-slot:actions>
    </x-form-card>
</x-layouts.admin>

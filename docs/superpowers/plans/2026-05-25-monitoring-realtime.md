# Monitoring Suhu & Kelembapan Real-Time — Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task. Steps use checkbox (`- [ ]`) syntax for tracking.

**Goal:** Halaman web monitoring yang menampilkan grafik suhu & kelembapan kandang secara real-time via WebSocket (Laravel Reverb + Chart.js).

**Architecture:** MQTT subscriber yang sudah ada di-extend agar broadcast event ke Laravel Reverb setiap terima data baru. Browser subscribe ke private WebSocket channel per-kandang menggunakan Laravel Echo, lalu push data point baru ke Chart.js tanpa refresh halaman.

**Tech Stack:** Laravel Reverb (WebSocket), Laravel Echo + Pusher JS (client), Chart.js (grafik), Alpine.js (interaktivitas), Blade (view)

---

## File Map

| Action | Path | Fungsi |
|--------|------|--------|
| Install | `composer require laravel/reverb` | Package WebSocket server |
| Create | `config/reverb.php` | Konfigurasi Reverb (auto via install:broadcasting) |
| Create | `config/broadcasting.php` | Konfigurasi broadcasting driver |
| Create | `routes/channels.php` | Definisi private channel authorization |
| Create | `app/Events/NewEnvironmentData.php` | Event broadcast data sensor baru |
| Modify | `app/Services/IoTService.php` | Tambah broadcast setelah simpan data |
| Modify | `.env` | Tambah env vars Reverb + ubah BROADCAST_CONNECTION |
| Create | `app/Http/Controllers/MonitoringController.php` | Controller halaman + API history |
| Modify | `routes/web.php` | Tambah route /monitoring |
| Create | `resources/views/monitoring/index.blade.php` | Halaman monitoring (chart + dropdown) |
| Modify | `resources/views/components/layouts/admin.blade.php` | Tambah sidebar link Monitoring |

---

## Task 1: Install & Konfigurasi Laravel Reverb

**Penjelasan:** Laravel Reverb adalah WebSocket server bawaan Laravel. Kita install ini agar bisa "push" data dari server ke browser secara real-time tanpa browser harus polling/refresh terus.

**Files:**
- Modify: `.env`
- Create: `config/reverb.php` (auto-generated)
- Create: `config/broadcasting.php` (auto-generated)
- Create: `routes/channels.php` (auto-generated)

- [ ] **Step 1: Install broadcasting via artisan**

```bash
cd C:\laragon\www\GoSheep-API
php artisan install:broadcasting
```

Ini akan otomatis:
- Install package `laravel/reverb`
- Buat `config/broadcasting.php`
- Buat `config/reverb.php`
- Buat `routes/channels.php`
- Tambah env vars di `.env`

Jika ditanya "Would you like to install Laravel Reverb?" jawab **yes**.

- [ ] **Step 2: Verifikasi env vars di `.env`**

Pastikan baris-baris ini ada di `.env` (sesuaikan jika perlu):

```env
BROADCAST_CONNECTION=reverb

REVERB_APP_ID=gosheep-local
REVERB_APP_KEY=gosheep-key
REVERB_APP_SECRET=gosheep-secret
REVERB_HOST=localhost
REVERB_PORT=8080
REVERB_SCHEME=http

VITE_REVERB_APP_KEY="${REVERB_APP_KEY}"
VITE_REVERB_HOST="${REVERB_HOST}"
VITE_REVERB_PORT="${REVERB_PORT}"
VITE_REVERB_SCHEME="${REVERB_SCHEME}"
```

**Penjelasan setiap variable:**
- `BROADCAST_CONNECTION=reverb` — memberitahu Laravel untuk kirim event via Reverb (bukan `log`)
- `REVERB_APP_ID/KEY/SECRET` — credential internal agar Echo client bisa connect ke Reverb
- `REVERB_HOST/PORT` — dimana Reverb server listen (localhost:8080 untuk development)

- [ ] **Step 3: Ubah QUEUE_CONNECTION**

Reverb butuh queue agar event broadcast diproses async. Ubah di `.env`:

```env
QUEUE_CONNECTION=database
```

Ini sudah `database`, jadi sudah benar. Pastikan tabel `jobs` sudah ada:

```bash
php artisan queue:table
php artisan migrate
```

- [ ] **Step 4: Test Reverb bisa start**

```bash
php artisan reverb:start
```

Expected: `Starting server on 0.0.0.0:8080...` (Ctrl+C untuk stop)

- [ ] **Step 5: Commit**

```bash
git add -A
git commit -m "feat: install dan konfigurasi Laravel Reverb untuk WebSocket"
```

---

## Task 2: Buat Event `NewEnvironmentData`

**Penjelasan:** Event ini adalah "pesan" yang dikirim dari server ke browser setiap kali ada data sensor baru masuk dari ESP32. Laravel Broadcasting akan kirim event ini via WebSocket channel.

**Files:**
- Create: `app/Events/NewEnvironmentData.php`

- [ ] **Step 1: Buat file event**

Buat file baru di `app/Events/NewEnvironmentData.php`:

```php
<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;

class NewEnvironmentData implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets;

    public function __construct(
        public int $cageId,
        public float $temperature,
        public float $humidity,
        public string $recordedAt
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("cage.{$this->cageId}");
    }

    public function broadcastAs(): string
    {
        return 'environment.updated';
    }

    public function broadcastWith(): array
    {
        return [
            'cage_id' => $this->cageId,
            'temperature' => $this->temperature,
            'humidity' => $this->humidity,
            'recorded_at' => $this->recordedAt,
        ];
    }
}
```

**Penjelasan per bagian:**
- `implements ShouldBroadcast` — memberi tahu Laravel bahwa event ini harus dikirim via WebSocket
- `broadcastOn()` — menentukan channel mana yang menerima event ini. `PrivateChannel("cage.{$this->cageId}")` artinya tiap kandang punya channel sendiri, jadi browser yang subscribe ke kandang 1 hanya terima data kandang 1
- `broadcastAs()` — nama event yang diterima di sisi browser (`environment.updated`)
- `broadcastWith()` — data JSON yang dikirim ke browser

- [ ] **Step 2: Commit**

```bash
git add app/Events/NewEnvironmentData.php
git commit -m "feat: buat event NewEnvironmentData untuk broadcast data sensor"
```

---

## Task 3: Definisikan Channel Authorization

**Penjelasan:** Karena kita pakai `PrivateChannel`, Laravel butuh tahu siapa yang boleh subscribe. Kita definisikan aturannya di `routes/channels.php`.

**Files:**
- Modify: `routes/channels.php`

- [ ] **Step 1: Tambah authorization rule**

Isi file `routes/channels.php` (mungkin sudah ada template dari install:broadcasting):

```php
<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('cage.{cageId}', function ($user, $cageId) {
    return $user !== null;
});
```

**Penjelasan:**
- `Broadcast::channel('cage.{cageId}', ...)` — mendefinisikan aturan untuk channel `cage.*`
- Callback return `true` jika user boleh subscribe. Di sini kita cukup cek user authenticated (`$user !== null`)
- Artinya: semua user yang sudah login boleh lihat data kandang manapun

- [ ] **Step 2: Commit**

```bash
git add routes/channels.php
git commit -m "feat: definisikan channel authorization untuk monitoring kandang"
```

---

## Task 4: Modifikasi IoTService untuk Broadcast Event

**Penjelasan:** Sekarang kita hubungkan MQTT subscriber dengan broadcasting. Setiap kali data sensor disimpan ke database, kita juga kirim event ke Reverb agar browser langsung terima.

**Files:**
- Modify: `app/Services/IoTService.php`

- [ ] **Step 1: Tambah broadcast event setelah save**

Ubah file `app/Services/IoTService.php` menjadi:

```php
<?php

namespace App\Services;

use App\Events\NewEnvironmentData;
use App\Models\CageEnvironmentLog;

class IoTService
{
    public function processEnvironmentData(
        int $cageId,
        array $data
    ): CageEnvironmentLog {
        $log = CageEnvironmentLog::create([
            'cage_id' => $cageId,
            'temperature' => $data['suhu'],
            'humidity' => $data['kelembapan'],
            'recorded_at' => now(),
        ]);

        NewEnvironmentData::dispatch(
            $cageId,
            (float) $log->temperature,
            (float) $log->humidity,
            $log->recorded_at->toIso8601String()
        );

        return $log;
    }
}
```

**Penjelasan perubahan:**
- `use App\Events\NewEnvironmentData` — import event class
- `NewEnvironmentData::dispatch(...)` — setelah data disimpan ke DB, kirim event ke Reverb. Ini yang nanti diterima browser via WebSocket.
- Kita pakai `toIso8601String()` agar format waktu standar dan mudah di-parse JavaScript

- [ ] **Step 2: Commit**

```bash
git add app/Services/IoTService.php
git commit -m "feat: broadcast NewEnvironmentData setelah simpan data sensor"
```

---

## Task 5: Buat MonitoringController

**Penjelasan:** Controller ini handle 2 hal: (1) tampilkan halaman monitoring, (2) endpoint API untuk ambil data history 24 jam saat pertama kali halaman dibuka atau ganti kandang.

**Files:**
- Create: `app/Http/Controllers/MonitoringController.php`

- [ ] **Step 1: Buat controller**

Buat file `app/Http/Controllers/MonitoringController.php`:

```php
<?php

namespace App\Http\Controllers;

use App\Models\Cage;
use App\Models\CageEnvironmentLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function index()
    {
        $cages = Cage::select('id', 'name')->orderBy('name')->get();

        return view('monitoring.index', compact('cages'));
    }

    public function history(int $cageId): JsonResponse
    {
        $logs = CageEnvironmentLog::where('cage_id', $cageId)
            ->where('recorded_at', '>=', now()->subHours(24))
            ->orderBy('recorded_at')
            ->get(['temperature', 'humidity', 'recorded_at']);

        return response()->json($logs);
    }
}
```

**Penjelasan:**
- `index()` — ambil daftar kandang untuk dropdown, lalu render halaman Blade
- `history($cageId)` — return JSON berisi data 24 jam terakhir untuk kandang tertentu. Ini dipanggil via AJAX saat user pilih kandang di dropdown.
- Query pakai index `(cage_id, recorded_at)` yang sudah ada di migration, jadi performan

- [ ] **Step 2: Commit**

```bash
git add app/Http/Controllers/MonitoringController.php
git commit -m "feat: buat MonitoringController untuk halaman dan API history"
```

---

## Task 6: Tambah Routes

**Penjelasan:** Daftarkan URL endpoint monitoring di file routes.

**Files:**
- Modify: `routes/web.php`

- [ ] **Step 1: Tambah route monitoring**

Tambahkan di dalam group `Route::middleware(['auth'])` di `routes/web.php`, sebelum tutup `});`:

```php
    // Monitoring IoT
    Route::get('/monitoring', [App\Http\Controllers\MonitoringController::class, 'index'])->name('monitoring.index');
    Route::get('/monitoring/{cage}/history', [App\Http\Controllers\MonitoringController::class, 'history'])->name('monitoring.history');
```

**Penjelasan:**
- `/monitoring` — halaman utama monitoring (perlu login)
- `/monitoring/{cage}/history` — API endpoint ambil data 24 jam, `{cage}` diganti ID kandang (misal `/monitoring/1/history`)
- Dua-duanya dalam middleware `auth`, jadi hanya user login yang bisa akses

- [ ] **Step 2: Commit**

```bash
git add routes/web.php
git commit -m "feat: tambah route monitoring di web.php"
```

---

## Task 7: Tambah Sidebar Link

**Penjelasan:** Tambah menu "Monitoring Lingkungan" di sidebar supaya user bisa navigasi ke halaman monitoring.

**Files:**
- Modify: `resources/views/components/layouts/admin.blade.php`

- [ ] **Step 1: Tambah section IoT di sidebar**

Di file `resources/views/components/layouts/admin.blade.php`, cari bagian setelah sidebar link "Riwayat Berat" (sekitar baris 94-95). Tambahkan section baru sebelum section "Lainnya":

```blade
            <p class="px-3 pt-5 pb-1.5 text-[10px] font-bold text-emerald-400/50 uppercase tracking-widest">IoT</p>

            <x-sidebar-link href="{{ route('monitoring.index') }}" icon="thermometer" :active="request()->is('monitoring*')">
                Monitoring Lingkungan
            </x-sidebar-link>
```

**Penjelasan:**
- Kita buat section baru "IoT" untuk grup menu terkait IoT
- Icon `thermometer` dari Lucide (sudah loaded di layout)
- `:active="request()->is('monitoring*')"` — highlight menu saat user di halaman monitoring

- [ ] **Step 2: Commit**

```bash
git add resources/views/components/layouts/admin.blade.php
git commit -m "feat: tambah sidebar link Monitoring Lingkungan"
```

---

## Task 8: Buat Halaman Monitoring (View Blade)

**Penjelasan:** Ini halaman utama yang user lihat. Ada dropdown pilih kandang, stat cards (suhu & kelembapan terkini), dan line chart. Pakai Alpine.js untuk reaktivitas dan Laravel Echo untuk real-time updates.

**Files:**
- Create: `resources/views/monitoring/index.blade.php`

- [ ] **Step 1: Buat folder dan file view**

Buat folder `resources/views/monitoring/` lalu buat file `index.blade.php`:

```blade
<x-layouts.admin title="Monitoring Lingkungan" header="Monitoring">

    {{-- CDN dependencies --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/pusher-js@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/laravel-echo@1/dist/echo.iife.js"></script>

    <div x-data="monitoringApp()" x-init="init()">

        {{-- Header Section --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-xl font-extrabold text-slate-800 tracking-tight">Monitoring Lingkungan Kandang</h1>
                <p class="text-xs text-slate-500 mt-1">Data suhu & kelembapan real-time dari sensor IoT</p>
            </div>

            {{-- Dropdown Pilih Kandang --}}
            <div class="w-full sm:w-64">
                <select x-model="selectedCage" @change="onCageChange()"
                    class="w-full px-4 py-2.5 bg-white border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm">
                    <option value="">— Pilih Kandang —</option>
                    @foreach($cages as $cage)
                        <option value="{{ $cage->id }}">{{ $cage->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Stat Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-6" x-show="selectedCage" x-cloak>
            {{-- Suhu --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Suhu Terkini</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">
                            <span x-text="currentTemp !== null ? currentTemp + '°C' : '—'"></span>
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-orange-50 flex items-center justify-center">
                        <i data-lucide="thermometer" class="w-6 h-6 text-orange-500"></i>
                    </div>
                </div>
            </div>

            {{-- Kelembapan --}}
            <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Kelembapan Terkini</p>
                        <p class="text-3xl font-extrabold text-slate-800 mt-1">
                            <span x-text="currentHumidity !== null ? currentHumidity + '%' : '—'"></span>
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center">
                        <i data-lucide="droplets" class="w-6 h-6 text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- Chart --}}
        <div class="bg-white border border-slate-100 rounded-2xl p-5 shadow-sm" x-show="selectedCage" x-cloak>
            <div class="flex items-center gap-2 mb-4">
                <i data-lucide="activity" class="w-4 h-4 text-emerald-500"></i>
                <h3 class="font-bold text-sm text-slate-800">Grafik 24 Jam Terakhir</h3>
                <span class="ml-auto inline-flex items-center gap-1.5 px-2 py-0.5 rounded-md bg-green-50 border border-green-100">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold text-green-600 uppercase tracking-wider">Live</span>
                </span>
            </div>
            <div class="relative h-[350px]">
                <canvas id="environmentChart"></canvas>
            </div>
        </div>

        {{-- Empty State --}}
        <div x-show="!selectedCage" class="bg-white border border-slate-100 rounded-2xl p-12 shadow-sm text-center">
            <div class="w-16 h-16 rounded-2xl bg-emerald-50 flex items-center justify-center mx-auto mb-4">
                <i data-lucide="radio-tower" class="w-8 h-8 text-emerald-400"></i>
            </div>
            <h3 class="font-bold text-slate-700 mb-1">Pilih Kandang</h3>
            <p class="text-xs text-slate-400">Pilih kandang dari dropdown di atas untuk melihat data monitoring.</p>
        </div>
    </div>

    <script>
        function monitoringApp() {
            return {
                selectedCage: '',
                currentTemp: null,
                currentHumidity: null,
                chart: null,
                echoChannel: null,

                init() {
                    window.Echo = new Echo({
                        broadcaster: 'pusher',
                        key: '{{ env("REVERB_APP_KEY") }}',
                        wsHost: '{{ env("REVERB_HOST", "localhost") }}',
                        wsPort: '{{ env("REVERB_PORT", 8080) }}',
                        forceTLS: false,
                        disableStats: true,
                        enabledTransports: ['ws'],
                    });
                },

                onCageChange() {
                    if (this.echoChannel) {
                        window.Echo.leave(`cage.${this.echoChannel}`);
                    }

                    if (!this.selectedCage) {
                        this.currentTemp = null;
                        this.currentHumidity = null;
                        if (this.chart) this.chart.destroy();
                        return;
                    }

                    this.echoChannel = this.selectedCage;
                    this.fetchHistory();
                    this.subscribeToChannel();
                },

                async fetchHistory() {
                    const response = await fetch(`/monitoring/${this.selectedCage}/history`);
                    const data = await response.json();

                    const labels = data.map(d => this.formatTime(d.recorded_at));
                    const temps = data.map(d => parseFloat(d.temperature));
                    const humids = data.map(d => parseFloat(d.humidity));

                    if (data.length > 0) {
                        const last = data[data.length - 1];
                        this.currentTemp = parseFloat(last.temperature).toFixed(1);
                        this.currentHumidity = parseFloat(last.humidity).toFixed(1);
                    }

                    this.renderChart(labels, temps, humids);
                },

                subscribeToChannel() {
                    window.Echo.private(`cage.${this.selectedCage}`)
                        .listen('.environment.updated', (e) => {
                            this.currentTemp = parseFloat(e.temperature).toFixed(1);
                            this.currentHumidity = parseFloat(e.humidity).toFixed(1);

                            const label = this.formatTime(e.recorded_at);
                            this.chart.data.labels.push(label);
                            this.chart.data.datasets[0].data.push(parseFloat(e.temperature));
                            this.chart.data.datasets[1].data.push(parseFloat(e.humidity));

                            if (this.chart.data.labels.length > 720) {
                                this.chart.data.labels.shift();
                                this.chart.data.datasets[0].data.shift();
                                this.chart.data.datasets[1].data.shift();
                            }

                            this.chart.update('none');
                        });
                },

                renderChart(labels, temps, humids) {
                    if (this.chart) this.chart.destroy();

                    const ctx = document.getElementById('environmentChart').getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    label: 'Suhu (°C)',
                                    data: temps,
                                    borderColor: '#f97316',
                                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 0,
                                    pointHitRadius: 10,
                                    yAxisID: 'y',
                                },
                                {
                                    label: 'Kelembapan (%)',
                                    data: humids,
                                    borderColor: '#3b82f6',
                                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                                    borderWidth: 2,
                                    tension: 0.3,
                                    fill: true,
                                    pointRadius: 0,
                                    pointHitRadius: 10,
                                    yAxisID: 'y1',
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false,
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        padding: 20,
                                        font: { size: 11, weight: '600' }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                    titleFont: { size: 11 },
                                    bodyFont: { size: 12, weight: '600' },
                                    padding: 10,
                                    cornerRadius: 8,
                                }
                            },
                            scales: {
                                x: {
                                    ticks: {
                                        font: { size: 10 },
                                        maxTicksLimit: 12,
                                        maxRotation: 0,
                                    },
                                    grid: { display: false }
                                },
                                y: {
                                    type: 'linear',
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Suhu (°C)',
                                        font: { size: 11, weight: '600' },
                                        color: '#f97316'
                                    },
                                    ticks: { font: { size: 10 } },
                                    grid: { color: 'rgba(0,0,0,0.04)' }
                                },
                                y1: {
                                    type: 'linear',
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Kelembapan (%)',
                                        font: { size: 11, weight: '600' },
                                        color: '#3b82f6'
                                    },
                                    ticks: { font: { size: 10 } },
                                    grid: { drawOnChartArea: false }
                                }
                            }
                        }
                    });
                },

                formatTime(dateStr) {
                    const d = new Date(dateStr);
                    return d.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });
                }
            };
        }
    </script>

</x-layouts.admin>
```

**Penjelasan per bagian utama:**

1. **CDN Scripts** — load Chart.js, Pusher JS (protocol yang Reverb gunakan), dan Laravel Echo (wrapper yang gampang subscribe channel)

2. **Alpine.js `x-data="monitoringApp()"`** — semua logika halaman dibungkus dalam satu Alpine component

3. **`init()`** — inisialisasi Echo client, connect ke Reverb server di localhost:8080

4. **`onCageChange()`** — dipanggil saat user ganti dropdown. Leave channel lama, fetch history baru, subscribe channel baru

5. **`fetchHistory()`** — AJAX GET ke `/monitoring/{id}/history`, ambil data 24 jam, render chart

6. **`subscribeToChannel()`** — subscribe ke private channel `cage.{id}`, setiap event `.environment.updated` masuk → push data baru ke chart + update stat cards. Limit 720 data points (24 jam × 30 data/jam) agar chart tidak terlalu berat.

7. **`renderChart()`** — buat Chart.js line chart dengan 2 Y-axis: kiri untuk suhu (oranye), kanan untuk kelembapan (biru)

8. **`formatTime()`** — format timestamp jadi HH:MM untuk label chart

- [ ] **Step 2: Commit**

```bash
git add resources/views/monitoring/index.blade.php
git commit -m "feat: buat halaman monitoring dengan grafik real-time"
```

---

## Task 9: Test End-to-End

**Penjelasan:** Verifikasi semua komponen bekerja bersama.

- [ ] **Step 1: Jalankan semua service yang dibutuhkan**

Buka 3 terminal terpisah:

Terminal 1 — Laravel server:
```bash
cd C:\laragon\www\GoSheep-API
php artisan serve
```

Terminal 2 — Reverb WebSocket server:
```bash
cd C:\laragon\www\GoSheep-API
php artisan reverb:start
```

Terminal 3 — MQTT Subscriber:
```bash
cd C:\laragon\www\GoSheep-API
php artisan mqtt:subscribe
```

- [ ] **Step 2: Buka browser dan test**

1. Buka `http://localhost:8000/login` → login
2. Klik "Monitoring Lingkungan" di sidebar
3. Pilih kandang dari dropdown
4. Grafik 24 jam terakhir muncul (jika ada data di DB)

- [ ] **Step 3: Test real-time dengan MQTT publish**

Buka terminal baru, gunakan mosquitto_pub untuk simulasi data sensor:

```bash
cd C:\Users\ACER\mqtt_broker
mosquitto_pub -h localhost -t "cages/1/environment" -m "{\"suhu\": 28.5, \"kelembapan\": 65.3}"
```

Expected: grafik di browser langsung update tanpa refresh, stat cards berubah ke 28.5°C dan 65.3%.

- [ ] **Step 4: Verifikasi selesai — commit final jika ada adjustment**

```bash
git status
```

Jika ada file yang perlu di-commit (misal minor fix):
```bash
git add -A
git commit -m "fix: minor adjustments dari testing end-to-end"
```

---

## Urutan Menjalankan (Checklist Ringkas)

1. ✅ Install Reverb (`php artisan install:broadcasting`)
2. ✅ Set env vars
3. ✅ Buat Event `NewEnvironmentData`
4. ✅ Definisikan channel authorization
5. ✅ Modifikasi IoTService (tambah broadcast)
6. ✅ Buat MonitoringController
7. ✅ Tambah routes
8. ✅ Tambah sidebar link
9. ✅ Buat halaman Blade (chart + Alpine + Echo)
10. ✅ Test end-to-end

## Prasyarat yang Harus Running

| Service | Command | Port |
|---------|---------|------|
| Laravel | `php artisan serve` | 8000 |
| Reverb | `php artisan reverb:start` | 8080 |
| MQTT Subscriber | `php artisan mqtt:subscribe` | — |
| Mosquitto Broker | Start dari `mqtt_broker/mosquitto.exe` | 1883 |
| Queue Worker | `php artisan queue:work` | — |

# Monitoring Suhu & Kelembapan Real-Time

**Tanggal:** 2026-05-25  
**Status:** Approved  
**Scope:** GoSheep-API (backend + web frontend)

---

## Ringkasan

Menambah halaman monitoring di web admin GoSheep yang menampilkan grafik suhu dan kelembapan kandang secara real-time. Data dikirim ESP32 via MQTT, disimpan Laravel, lalu di-broadcast ke browser via WebSocket (Laravel Reverb) sehingga grafik otomatis update tanpa refresh.

---

## Arsitektur Data Flow

```
ESP32 (DHT22)
    │ MQTT publish → topic: cages/{cage_id}/environment
    ▼
Mosquitto Broker (lokal, port 1883)
    │
    ▼
php artisan mqtt:subscribe (Laravel Command)
    │
    ▼
IoTService::processEnvironmentData()
    ├── Simpan ke tabel cage_environment_logs
    └── Broadcast event NewEnvironmentData via Laravel Reverb
                │
                ▼ WebSocket (port 8080)
Browser (Laravel Echo JS + Chart.js)
    └── Update grafik real-time
```

---

## Stack Teknologi

| Komponen | Pilihan |
|----------|---------|
| WebSocket Server | Laravel Reverb (self-hosted, gratis) |
| Chart Library | Chart.js (CDN) |
| JS Reactivity | Alpine.js (sudah ada) |
| WS Client | Laravel Echo + Pusher JS (Reverb-compatible) |
| Styling | Tailwind CSS (konsisten dengan existing) |

---

## Komponen Backend

### 1. Install Laravel Reverb

- Package: `laravel/reverb`
- Config: `config/reverb.php` + env vars (`REVERB_APP_ID`, `REVERB_APP_KEY`, `REVERB_APP_SECRET`, `REVERB_HOST`, `REVERB_PORT`)
- Jalankan: `php artisan reverb:start`

### 2. Event: `NewEnvironmentData`

- Path: `app/Events/NewEnvironmentData.php`
- Implements: `ShouldBroadcast`
- Channel: Private channel `cage.{cageId}`
- Payload: `{ cage_id, temperature, humidity, recorded_at }`

### 3. Modifikasi IoTService

- Setelah `CageEnvironmentLog::create(...)`, tambah `event(new NewEnvironmentData(...))`
- Tidak mengubah logika existing, hanya menambah 1 baris broadcast

### 4. Channel Authorization

- File: `routes/channels.php`
- Rule: `Broadcast::channel('cage.{cageId}', fn($user) => true)` — semua user authenticated boleh listen

### 5. MonitoringController

- Path: `app/Http/Controllers/MonitoringController.php`
- Method `index()`: render halaman monitoring (view `monitoring.index`)
- Method `history(Request $request, int $cageId)`: return JSON data 24 jam terakhir dari `cage_environment_logs` untuk chart initial load

### 6. Routes

- `GET /monitoring` → `MonitoringController@index` (halaman)
- `GET /monitoring/{cage}/history` → `MonitoringController@history` (API JSON)

---

## Komponen Frontend

### 1. Sidebar Link

- Tambah section "IoT" di sidebar (`admin.blade.php`)
- Link: "Monitoring Lingkungan" dengan icon `thermometer`

### 2. Halaman Monitoring (`monitoring/index.blade.php`)

Layout (atas ke bawah):
1. **Header**: Judul "Monitoring Lingkungan Kandang"
2. **Dropdown pilih kandang**: Select dari daftar cage yang ada
3. **2 Stat Cards** (inline): Suhu terkini + Kelembapan terkini (update real-time)
4. **Line Chart** (Chart.js): 2 dataset — suhu (warna oranye) & kelembapan (warna biru). Sumbu X = waktu (24 jam terakhir), sumbu Y kiri = suhu (°C), sumbu Y kanan = kelembapan (%)

### 3. Interaksi

- User pilih kandang → fetch history 24 jam via AJAX → render chart
- Subscribe ke channel WebSocket `cage.{id}` → setiap event baru, push data point ke chart + update stat cards
- Ganti kandang → unsubscribe channel lama, subscribe channel baru, fetch history baru

### 4. Dependencies (CDN)

- Chart.js: `https://cdn.jsdelivr.net/npm/chart.js`
- Laravel Echo: `https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.js`
- Pusher JS: `https://cdn.jsdelivr.net/npm/pusher-js` (Reverb-compatible)

---

## Desain Visual

- Mengikuti 100% style existing: emerald/green theme, glass-panel, Plus Jakarta Sans
- Stat cards menggunakan komponen `<x-stat-card>` yang sudah ada
- Chart background putih dengan border subtle (`border-slate-200`)
- Responsive: chart full-width, stat cards grid 2 kolom di desktop, stack di mobile

---

## Data Model (Existing)

Tabel `cage_environment_logs` sudah ada:

| Kolom | Tipe |
|-------|------|
| id | bigint PK |
| cage_id | FK → cages |
| temperature | decimal(5,2) |
| humidity | decimal(5,2) |
| recorded_at | timestamp |
| created_at | timestamp |
| updated_at | timestamp |

Index: `(cage_id, recorded_at)` — sudah ada, cukup performan untuk query 24 jam.

---

## Yang TIDAK termasuk scope

- Alert/notifikasi saat suhu abnormal (nanti)
- Monitoring di mobile app Flutter (nanti)
- Multiple sensor per kandang (saat ini 1 ESP32 = 1 kandang)
- Export data ke CSV/PDF
- Konfigurasi threshold oleh user

---

## Prasyarat Menjalankan

1. Mosquitto broker running (sudah ada di `C:\Users\ACER\mqtt_broker\`)
2. `php artisan mqtt:subscribe` running (subscriber MQTT)
3. `php artisan reverb:start` running (WebSocket server)
4. ESP32 connected ke WiFi dan publish ke broker

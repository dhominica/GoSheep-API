# 🐑 Smart Breeding — Backend

REST API backend untuk sistem rekomendasi perkawinan domba berbasis AI. Mengelola data ternak, kandang, pencatatan berat & kesehatan, serta integrasi dengan AI service dan IoT.

---

## Tech Stack

`Laravel` · `MySQL` · `MQTT (HiveMQ / Mosquitto)`

---

## Setup

```bash
composer install
cp .env.example .env
php artisan key:generate

# Konfigurasi DB di .env, lalu:
php artisan migrate --seed
php artisan serve
```

---

## Fitur Utama

- Manajemen domba, kandang, dan ras
- Pencatatan berat manual & otomatis via IoT (MQTT)
- Pencatatan kondisi kesehatan domba
- Integrasi rekomendasi kawin dari AI service (FastAPI)
- Pencatatan perkawinan & kelahiran
- Activity log untuk seluruh aksi pengguna
- Role-based access control (owner / staff)

---

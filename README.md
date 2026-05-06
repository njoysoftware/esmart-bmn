# SMART BMN

Sistem Manajemen Aset Barang Milik Negara (BMN)  
Bawaslu Kabupaten Lamongan

---

## 📌 Deskripsi

SMART BMN adalah aplikasi berbasis web untuk mengelola aset Barang Milik Negara (BMN) yang meliputi:

- Pendataan aset barang
- Monitoring kondisi barang
- Maintenance / perbaikan aset
- Laporan dan statistik aset
- Dashboard analitik berbasis Filament

---

## ⚙️ Teknologi

- Laravel

---

## 👥 Role Pengguna

| Role  | Akses                                  |
| ----- | -------------------------------------- |
| Admin | Full akses (CRUD, dashboard, settings) |
| User  | Input dan update data aset             |

---

## 🚀 Instalasi

### 1. Clone Repository

git clone https://github.com/username/smart-bmn.git
cd smart-bmn

### 2. Install Dependency PHP

composer install

### 3. Install Dependency Frontend

npm install

### 4. Copy Environment

cp .env.example .env

### 5. Generate App Key

php artisan key:generate

### 6. Setup Database

DB_DATABASE=smart_bmn
DB_USERNAME=root
DB_PASSWORD=

php artisan migrate --seed

### 7. Build Frontend

Development:
npm run dev

Production:
npm run build

### 8. Jalankan Server

php artisan serve

Akses:
http://127.0.0.1:8000

---

## 🔐 Login Admin

/admin

---

## 📊 Fitur

- Dashboard aset BMN
- Grafik pergerakan barang
- Status kondisi barang
- Maintenance aset
- Role management

---

## 👨‍💻 Developer

SMART BMN System - Bawaslu Kabupaten Lamongan

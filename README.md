# One Time Secret - KOMINFO JATIM

Website ini merupakan sistem untuk mengirim pesan rahasia satu kali baca. Sistem ini dikembangkan untuk keperluan keamanan pertukaran informasi rahasia agar hanya bisa dibaca sekali oleh penerima, setelah itu pesan akan otomatis terhapus.

> **Catatan:** Proyek ini dibuat untuk Kerja Praktik (KP) di Telkom University Surabaya bekerja sama dengan KOMINFO JATIM.

---

## 🔧 Cara Instalasi (Local Development)

### 1. Clone Repository

```bash
# Buat folder kerja
mkdir namafolder
cd namafolder

# Clone project
git clone https://github.com/haritsuddin-telu/OTSkominfo.git
cd OTSkominfo

# Tarik update terbaru
git pull origin main
```

### 2. Buka di Visual Studio Code
```bash
code .
```

### 3. Setup Laravel Backend
```bash
# Install dependencies PHP
composer install

# Salin file konfigurasi .env
cp .env.example .env

# Generate key aplikasi
php artisan key:generate

# Migrasi dan seeding database
php artisan migrate --seed
```

### 4. Setup Frontend (Vite)
```bash
npm install
npm run dev
```

### 5. Jalankan Server Laravel
```bash
php artisan serve
```

Setelah itu, buka di browser:
```
http://127.0.0.1:8000
```

---

## 🧪 Dokumentasi API
Endpoint API dapat diakses melalui Postman di:  
[https://documenter.getpostman.com/view/43933947/2sB3BLhSLt](https://documenter.getpostman.com/view/43933947/2sB3BLhSLt)

---

## 👨‍💻 Teknologi yang Digunakan

| Teknologi      | Keterangan |
|----------------|------------|
| Laravel        | Framework backend utama |
| Jetstream      | Autentikasi (login, register, verifikasi email) |
| Spatie         | Manajemen role & permission |
| MySQL          | Database relasional |
| Vite           | Build tool frontend modern |
| Tailwind CSS   | Styling tampilan antarmuka |
| Postman        | Dokumentasi dan pengujian API |
| Composer       | Manajemen dependensi PHP |
| Node.js & NPM  | Manajemen dependensi JavaScript dan build asset frontend |

---

## 📌 Catatan Tambahan
- Pastikan file `.env` sudah diatur sesuai konfigurasi database lokal.
- Jika `npm run dev` error, periksa versi Node.js.
- Jetstream & Spatie sudah terintegrasi untuk autentikasi dan otorisasi.

---

## 📄 Lisensi
Proyek ini digunakan untuk tujuan edukasi dan pengembangan selama Kerja Praktik.
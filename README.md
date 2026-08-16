# SIMPATI

## Sistem Informasi Monitoring Produktivitas dan Absensi Teknisi

SIMPATI (**Sistem Informasi Monitoring Produktivitas dan Absensi Teknisi**) adalah aplikasi berbasis web yang dikembangkan untuk membantu proses **pencatatan absensi, pemantauan lokasi, pengelolaan pekerjaan, pengukuran produktivitas, serta pembuatan laporan teknisi**.

Sistem ini dirancang untuk mendukung aktivitas operasional teknisi, khususnya dalam lingkungan kerja **PT Telkom Indonesia**, dengan memanfaatkan teknologi berbasis web dan geolocation untuk meningkatkan keteraturan, transparansi, dan kemudahan monitoring pekerjaan teknisi.

---

## 📌 Tentang Project

SIMPATI dikembangkan sebagai solusi untuk membantu proses monitoring teknisi yang sebelumnya dapat dilakukan secara manual atau tersebar di beberapa proses.

Sistem mengintegrasikan beberapa proses utama:

* Absensi teknisi
* Check In dan Check Out
* Pencatatan lokasi teknisi
* Monitoring lokasi teknisi
* Input hasil pekerjaan
* Riwayat pekerjaan
* Target produktivitas
* Monitoring pencapaian target
* Pengelolaan data teknisi
* Pengelolaan divisi
* Laporan pekerjaan
* Laporan absensi
* Export laporan
* Monitoring berdasarkan divisi

Dengan sistem terintegrasi, administrator dapat memperoleh informasi mengenai aktivitas dan produktivitas teknisi secara lebih terstruktur.

---

# 🎯 Tujuan Sistem

SIMPATI dikembangkan dengan beberapa tujuan utama:

1. Meningkatkan efisiensi proses pencatatan absensi teknisi.
2. Membantu administrator memonitor status kerja teknisi.
3. Mencatat lokasi teknisi berdasarkan koordinat GPS.
4. Memastikan teknisi melakukan aktivitas kerja sesuai prosedur.
5. Mempermudah pencatatan hasil pekerjaan teknisi.
6. Mengukur pencapaian produktivitas berdasarkan target divisi.
7. Mempermudah administrator dalam melakukan monitoring.
8. Mengurangi proses pencatatan dan rekapitulasi secara manual.
9. Menyediakan data historis pekerjaan dan absensi.
10. Membantu menghasilkan laporan operasional secara lebih cepat dan terstruktur.

---

# 🚀 Fitur Utama

## 1. Authentication

Sistem menyediakan autentikasi pengguna untuk membatasi akses berdasarkan role.

Pengguna dapat login ke sistem menggunakan:

* Email
* Password

Setelah berhasil login, pengguna akan diarahkan ke dashboard sesuai dengan role masing-masing.

---

# 👥 Role Pengguna

SIMPATI menggunakan sistem role untuk membedakan hak akses pengguna.

Role utama dalam sistem:

### Admin

Admin memiliki akses untuk mengelola dan memonitor aktivitas teknisi.

Admin dapat:

* Melihat dashboard
* Mengelola teknisi
* Mengelola divisi
* Mengatur target produktivitas
* Melihat pekerjaan teknisi
* Melihat monitoring teknisi
* Melihat absensi
* Melihat laporan
* Melihat detail laporan
* Melakukan export laporan
* Mengelola data teknisi

### Teknisi

Teknisi menggunakan sistem untuk menjalankan aktivitas operasional.

Teknisi dapat:

* Melihat dashboard
* Melakukan Check In
* Melakukan Check Out
* Mengirim lokasi GPS
* Memperbarui lokasi secara berkala
* Menginput hasil pekerjaan
* Melihat riwayat pekerjaan
* Melihat detail pekerjaan
* Mengubah profil
* Mengubah password

---

# 🏢 Divisi Teknisi

SIMPATI menggunakan pembagian teknisi berdasarkan divisi.

Divisi utama yang digunakan:

### Provisioning

Divisi yang menangani pekerjaan pemasangan atau aktivasi layanan pelanggan.

Data pekerjaan Provisioning meliputi:

* Nomor WO
* SC Order
* Nama pelanggan
* Alamat pelanggan
* ALPRO
* Segmen
* Jenis pekerjaan
* Deskripsi pekerjaan
* Foto bukti pekerjaan

Jenis pekerjaan yang tersedia antara lain:

* Pasang Baru
* Migrasi
* Upgrade/Downgrade
* Aktivasi
* Lainnya

### Assurance

Divisi yang menangani gangguan dan perbaikan layanan pelanggan.

Data pekerjaan Assurance meliputi:

* Nomor Tiket
* Nama pelanggan
* Alamat pelanggan
* ALPRO
* Jenis pekerjaan
* Deskripsi pekerjaan
* Foto bukti pekerjaan

Jenis pekerjaan yang tersedia antara lain:

* Gangguan Internet
* Gangguan IndiHome
* Perbaikan Jaringan
* Maintenance
* Lainnya

### Maintenance

Divisi Maintenance disiapkan sebagai bagian dari struktur divisi sistem untuk kebutuhan pengelolaan pekerjaan pemeliharaan.

---

# 📍 Sistem Absensi dan GPS

Salah satu fitur utama SIMPATI adalah pencatatan absensi berbasis lokasi.

Teknisi melakukan:

```text
Check In
    ↓
Lokasi GPS diperoleh
    ↓
Absensi disimpan
    ↓
Lokasi teknisi disimpan
    ↓
Teknisi bekerja
    ↓
Lokasi diperbarui secara berkala
    ↓
Check Out
    ↓
Lokasi Check Out disimpan
```

## Check In

Check In dapat dilakukan mulai pukul:

**07.00**

Saat Check In, sistem mengambil:

* Latitude
* Longitude
* Waktu Check In
* Tanggal
* User teknisi
* Status absensi

Data lokasi juga disimpan ke tabel `lokasi_teknisis`.

---

# 🛰️ Monitoring Lokasi Teknisi

Setelah teknisi melakukan Check In, sistem dapat memperbarui lokasi teknisi secara berkala.

Pada sisi browser digunakan Geolocation API untuk memperoleh:

```text
Latitude
Longitude
```

Kemudian data dikirimkan ke server.

Contoh mekanisme:

```text
Browser Teknisi
       ↓
GPS / Geolocation API
       ↓
Latitude + Longitude
       ↓
Laravel
       ↓
lokasi_teknisis
       ↓
Dashboard Admin
```

Lokasi teknisi diperbarui secara berkala untuk membantu proses monitoring.

---

# 🟢 Status Lokasi

Pada halaman input pekerjaan, sistem melakukan pengecekan lokasi teknisi.

Jika lokasi aktif:

> Lokasi aktif. Anda dapat menginput pekerjaan.

Jika lokasi tidak tersedia:

> Lokasi tidak aktif. Aktifkan GPS/lokasi perangkat terlebih dahulu.

Tombol **Simpan Pekerjaan** akan dinonaktifkan ketika browser tidak dapat memperoleh lokasi.

Selain pemeriksaan pada sisi browser, validasi lokasi juga dapat dilakukan pada sisi server untuk meningkatkan keamanan sistem.

---

# ⏰ Check Out

Check Out hanya dapat dilakukan mulai pukul:

**17.00**

Sistem akan memeriksa:

1. Apakah teknisi sudah Check In.
2. Apakah teknisi sudah Check Out sebelumnya.
3. Apakah waktu sudah mencapai pukul 17.00.

Saat Check Out, sistem mencatat:

* Jam keluar
* Latitude keluar
* Longitude keluar
* Status menjadi `offline`

---

# 📊 Dashboard Teknisi

Dashboard teknisi menampilkan informasi utama seperti:

* Status kerja
* Status absensi
* Jumlah pekerjaan hari ini
* Target pekerjaan hari ini
* Persentase pencapaian target
* Status Check In
* Status Check Out

Contoh indikator:

```text
Status Kerja
Online / Offline

Status Absensi
Sudah Check In / Belum Check In

Pekerjaan Hari Ini
3

Target Hari Ini
3 / 5

Pencapaian
60%
```

---

# 🎯 Target Produktivitas

SIMPATI menyediakan fitur target produktivitas teknisi.

Target dapat dikaitkan dengan divisi teknisi.

Contoh:

```text
Provisioning
Target = 4 pekerjaan/hari

Assurance
Target = 5 pekerjaan/hari
```

Persentase pencapaian dihitung berdasarkan:

```text
Persentase =
(Jumlah pekerjaan / Target harian) × 100%
```

Nilai maksimum persentase pada dashboard dibatasi sampai 100%.

Contoh:

```text
Jumlah pekerjaan = 4
Target = 5

Persentase = 80%
```

---

# 📝 Input Hasil Pekerjaan

Teknisi dapat mencatat pekerjaan yang telah diselesaikan melalui halaman:

```text
Input Hasil Pekerjaan
```

Setiap pekerjaan menyimpan informasi seperti:

* User teknisi
* Nomor tiket atau nomor WO
* SC Order
* ALPRO
* Segmen
* Nama pelanggan
* Alamat pelanggan
* Jenis pekerjaan
* Deskripsi
* Foto pekerjaan
* Tanggal pekerjaan
* Status
* Jam selesai

Status pekerjaan yang disimpan sebagai hasil pekerjaan selesai:

```text
selesai
```

---

# 🧾 Validasi Form Pekerjaan

Sistem menggunakan validasi Laravel untuk memastikan data pekerjaan memenuhi persyaratan.

Contoh validasi Assurance:

```text
Nomor Tiket        wajib dan unik
Nama Pelanggan     wajib
Alamat             wajib
Jenis Pekerjaan    wajib
Deskripsi          wajib
ALPRO              wajib
Foto               opsional
```

Contoh validasi Provisioning:

```text
Nomor WO           wajib dan unik
SC Order           wajib
Nama Pelanggan     wajib
Alamat             wajib
Jenis Pekerjaan    wajib
Deskripsi          wajib
ALPRO              wajib
Segmen             wajib
Foto               opsional
```

Jika terjadi kesalahan validasi, Laravel mengembalikan data input sebelumnya menggunakan `old()` sehingga teknisi tidak perlu mengisi seluruh form dari awal.

Catatan:

**File foto perlu dipilih kembali apabila form dikembalikan oleh browser setelah validasi gagal.**

---

# 📚 Riwayat Pekerjaan

Teknisi dapat melihat seluruh pekerjaan yang pernah dilakukan melalui halaman riwayat.

Data ditampilkan berdasarkan user yang sedang login.

Riwayat menggunakan pagination sehingga data dalam jumlah besar tetap mudah ditampilkan.

Contoh:

```text
Pekerjaan #1
Pekerjaan #2
Pekerjaan #3
...
```

Teknisi juga dapat membuka detail pekerjaan tertentu.

---

# 🔎 Detail Pekerjaan

Detail pekerjaan menampilkan informasi lengkap mengenai pekerjaan yang telah dilakukan.

Informasi dapat mencakup:

* Nomor tiket
* Nomor WO
* SC Order
* Pelanggan
* Alamat
* ALPRO
* Segmen
* Jenis pekerjaan
* Deskripsi
* Foto
* Tanggal
* Jam selesai
* Status

---

# 👤 Profil Teknisi

Teknisi dapat melihat profil pribadi.

Informasi profil meliputi:

* Nama
* NIK
* Email
* Nomor HP
* Divisi
* Alamat
* Foto profil

Teknisi dapat memperbarui:

* Nama
* Nomor HP
* Alamat
* Foto profil

Data seperti NIK dan email dapat dibatasi sesuai aturan sistem.

---

# 🔐 Ubah Password

Teknisi dapat mengganti password melalui halaman ubah password.

Sistem memeriksa:

1. Password lama wajib diisi.
2. Password lama harus sesuai.
3. Password baru minimal 6 karakter.
4. Konfirmasi password harus sama.

Jika password lama salah:

```text
Password lama tidak sesuai.
```

Jika berhasil:

```text
Password berhasil diubah.
```

Password disimpan menggunakan hashing Laravel.

---

# 🖥️ Dashboard Admin

Dashboard Admin digunakan untuk memonitor aktivitas teknisi secara keseluruhan.

Informasi yang dapat ditampilkan antara lain:

* Jumlah teknisi
* Status teknisi
* Jumlah pekerjaan
* Target produktivitas
* Absensi
* Monitoring
* Laporan
* Data berdasarkan divisi

---

# 👨‍🔧 Manajemen Teknisi

Admin dapat mengelola data teknisi.

Data teknisi meliputi:

* Nama
* NIK
* Email
* Password
* Divisi
* Nomor HP
* Alamat
* Foto
* Status

Status teknisi:

```text
Aktif
Nonaktif
```

---

# 🏢 Manajemen Divisi

Admin dapat mengelola divisi teknisi.

Struktur divisi meliputi:

```text
Divisi
├── Provisioning
├── Assurance
└── Maintenance
```

Setiap divisi dapat memiliki target produktivitas default dan keterangan.

---

# 📈 Monitoring Produktivitas

Admin dapat memonitor produktivitas teknisi berdasarkan:

* Teknisi
* Divisi
* Jumlah pekerjaan
* Target
* Persentase pencapaian
* Status pekerjaan
* Tanggal pekerjaan

Tujuan monitoring adalah membantu mengetahui apakah produktivitas teknisi telah mencapai target yang ditentukan.

---

# 📍 Monitoring Teknisi

Admin dapat melihat data lokasi teknisi yang dikirim oleh sistem.

Data lokasi terdiri dari:

* Teknisi
* Latitude
* Longitude
* Waktu update
* Absensi terkait

Lokasi digunakan sebagai bagian dari monitoring aktivitas teknisi.

---

# 🕒 Monitoring Absensi

Admin dapat memonitor absensi berdasarkan divisi.

Halaman monitoring disiapkan untuk:

* Absensi Provisioning
* Absensi Assurance

Data yang dapat ditampilkan:

* Teknisi
* Tanggal
* Jam masuk
* Jam keluar
* Status
* Lokasi masuk
* Lokasi keluar

---

# 📑 Laporan

SIMPATI menyediakan fitur laporan untuk membantu administrator melakukan rekapitulasi data.

Laporan dapat digunakan untuk melihat:

* Data pekerjaan
* Data absensi
* Produktivitas teknisi
* Data berdasarkan divisi
* Detail pekerjaan

Sistem juga memiliki fitur export laporan.

---

# 📤 Export Laporan

Project menggunakan class:

```text
app/Exports/LaporanExport.php
```

untuk mendukung proses export laporan.

Export digunakan agar data operasional dapat digunakan kembali untuk kebutuhan administrasi dan dokumentasi.

---

# 🗃️ Struktur Database

Database SIMPATI menggunakan beberapa tabel utama.

```text
users
   │
   └── teknisis
          │
          └── divisis

divisis
   │
   └── target_produktivitas

users
   │
   ├── absensis
   │
   ├── lokasi_teknisis
   │
   └── pekerjaans
```

## Tabel Utama

### users

Menyimpan data akun pengguna.

Contoh field:

```text
id
nama
email
password
role
divisi_id
no_hp
foto
is_active
```

### divisis

Menyimpan data divisi.

```text
id
nama_divisi
target_default
keterangan
```

### teknisis

Menyimpan informasi teknisi.

```text
id
user_id
nik
nama
divisi
no_hp
alamat
status
```

### target_produktivitas

Menyimpan target produktivitas berdasarkan divisi.

```text
id
divisi_id
target
```

### pekerjaans

Menyimpan hasil pekerjaan teknisi.

Data yang digunakan antara lain:

```text
id
user_id
nomor_tiket
nomor_wo
sc_order
alpro
segmen
nama_pelanggan
alamat_pelanggan
jenis_pekerjaan
deskripsi
foto
tanggal
status
jam_selesai
```

### absensis

Menyimpan data absensi.

Data meliputi:

```text
id
user_id
tanggal
jam_masuk
jam_keluar
latitude_masuk
longitude_masuk
latitude_keluar
longitude_keluar
status
```

### lokasi_teknisis

Menyimpan histori/update lokasi teknisi.

Data meliputi:

```text
id
user_id
absensi_id
latitude
longitude
alamat
waktu_update
```

---

# 🔄 Alur Sistem

## Alur Teknisi

```text
Login
  ↓
Dashboard
  ↓
Check In
  ↓
GPS diperoleh
  ↓
Status Online
  ↓
Lokasi diperbarui
  ↓
Melakukan pekerjaan
  ↓
Input hasil pekerjaan
  ↓
Validasi data + lokasi
  ↓
Pekerjaan tersimpan
  ↓
Target produktivitas bertambah
  ↓
Check Out
  ↓
Status Offline
```

---

# 🔄 Alur Admin

```text
Login
  ↓
Dashboard Admin
  ↓
Kelola Teknisi
  ↓
Kelola Divisi
  ↓
Kelola Target
  ↓
Monitoring Absensi
  ↓
Monitoring Teknisi
  ↓
Monitoring Pekerjaan
  ↓
Laporan
  ↓
Export
```

---

# 🛠️ Teknologi yang Digunakan

SIMPATI dibangun menggunakan teknologi web modern.

### Backend

* PHP
* Laravel

### Frontend

* Blade Template
* HTML
* CSS
* JavaScript
* Bootstrap
* Font Awesome

### Database

* MySQL

### Authentication

* Laravel Authentication

### Location

* Browser Geolocation API
* Latitude
* Longitude

### Storage

Laravel Filesystem dengan public disk digunakan untuk penyimpanan:

* Foto profil
* Foto pekerjaan

### Development Environment

Project dikembangkan menggunakan:

* Laragon
* Visual Studio Code
* Git
* GitHub

---

# 📂 Struktur Project

Struktur utama aplikasi Laravel:

```text
SIMPATI/
│
├── app/
│   ├── Exports/
│   │   └── LaporanExport.php
│   │
│   ├── Http/
│   │   └── Controllers/
│   │       ├── AdminController.php
│   │       └── TeknisiController.php
│   │
│   └── Models/
│       ├── Absensi.php
│       ├── LokasiTeknisi.php
│       ├── Pekerjaan.php
│       ├── TargetProduktivitas.php
│       ├── Teknisi.php
│       └── User.php
│
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   ├── DivisiSeeder.php
│   │   └── TargetProduktivitasSeeder.php
│   └── factories/
│
├── resources/
│   └── views/
│       ├── admin/
│       ├── teknisi/
│       ├── layoutsAdmin/
│       └── layoutsTeknisi/
│
├── routes/
│   └── web.php
│
├── storage/
│
├── public/
│
├── .env
├── composer.json
└── README.md
```

---

# ⚙️ Instalasi

## 1. Clone Repository

Clone repository project:

```bash
git clone https://github.com/Shabir2784/simpati-plasa-telkom-majene.git
```

Masuk ke folder project:

```bash
cd simpati-plasa-telkom-majene
```

---

## 2. Install Dependency

Install dependency Laravel:

```bash
composer install
```

Jika project menggunakan dependency frontend:

```bash
npm install
```

---

## 3. Konfigurasi Environment

Copy file `.env.example` menjadi `.env`:

```bash
cp .env.example .env
```

Pada Windows dapat dilakukan dengan:

```bash
copy .env.example .env
```

Kemudian konfigurasi database pada `.env`.

Contoh:

```env
APP_NAME=SIMPATI
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=simpati
DB_USERNAME=root
DB_PASSWORD=
```

---

## 4. Generate Application Key

Jalankan:

```bash
php artisan key:generate
```

---

## 5. Migrasi Database

Jalankan:

```bash
php artisan migrate
```

Jika ingin membuat database dari awal sekaligus menjalankan seeder:

```bash
php artisan migrate:fresh --seed
```

**Perhatian:** `migrate:fresh` akan menghapus seluruh tabel dan data database yang ada.

---

## 6. Storage Link

Karena aplikasi menyimpan foto menggunakan Laravel public disk, jalankan:

```bash
php artisan storage:link
```

Hal ini diperlukan agar file yang tersimpan di:

```text
storage/app/public
```

dapat diakses melalui:

```text
public/storage
```

---

## 7. Menjalankan Project

Jalankan Laravel:

```bash
php artisan serve
```

Kemudian buka:

```text
http://127.0.0.1:8000
```

Jika menggunakan Laragon, project juga dapat dijalankan melalui virtual host Laragon.

---

# 🔐 Keamanan

SIMPATI menerapkan beberapa mekanisme keamanan dasar:

* Authentication
* Authorization berdasarkan role
* CSRF protection Laravel
* Password hashing
* Validasi input
* Validasi file upload
* Unique validation untuk data tertentu
* Server-side validation
* Pembatasan akses data berdasarkan user
* Validasi lokasi pada sisi server

Contoh:

Teknisi hanya dapat melihat riwayat pekerjaan miliknya sendiri.

---

# 📍 Validasi Lokasi

Validasi lokasi dilakukan melalui dua sisi.

### Client-side

Browser memeriksa apakah Geolocation API tersedia dan dapat memperoleh koordinat.

### Server-side

Laravel memeriksa data lokasi yang tersimpan pada server sebelum menerima pekerjaan.

Hal ini penting karena validasi JavaScript saja tidak cukup untuk menjaga keamanan aplikasi.

---

# 🧪 Pengujian Sistem

Beberapa skenario pengujian yang dapat dilakukan:

### Pengujian Login

```text
Email benar + password benar
→ Login berhasil
```

```text
Email/password salah
→ Login ditolak
```

### Pengujian Check In

```text
Sebelum 07.00
→ Check In tidak tersedia
```

```text
Mulai 07.00
→ Check In tersedia
```

### Pengujian Check Out

```text
Sebelum 17.00
→ Check Out ditolak
```

```text
Mulai 17.00
→ Check Out tersedia
```

### Pengujian GPS

```text
GPS aktif
→ Lokasi diperoleh
→ Input pekerjaan diperbolehkan
```

```text
GPS tidak aktif
→ Input pekerjaan ditolak
```

### Pengujian Produktivitas

```text
Pekerjaan = 3
Target = 5
→ 60%
```

---

# 🌐 Deployment

Sebelum melakukan deployment ke hosting/server, beberapa konfigurasi harus disesuaikan.

Contoh:

```env
APP_ENV=production
APP_DEBUG=false
```

Database production harus dikonfigurasi sesuai server.

Pastikan juga:

```bash
php artisan storage:link
```

sudah dijalankan.

Folder storage dan cache Laravel harus memiliki permission yang sesuai.

---

# 🔄 Git & GitHub

Project menggunakan Git sebagai version control.

Untuk melihat perubahan:

```bash
git status
```

Menambahkan perubahan:

```bash
git add .
```

Membuat commit:

```bash
git commit -m "Update sistem SIMPATI"
```

Mengirim perubahan ke GitHub:

```bash
git push origin main
```

Workflow pengembangan:

```text
Coding
  ↓
Testing
  ↓
git status
  ↓
git add .
  ↓
git commit
  ↓
git push
  ↓
GitHub
```

---

# 📊 Manfaat Sistem

Dengan adanya SIMPATI, proses operasional teknisi diharapkan menjadi lebih:

### Efisien

Data pekerjaan dan absensi tersimpan secara digital sehingga mengurangi pencatatan manual.

### Transparan

Aktivitas pekerjaan dan absensi dapat dipantau berdasarkan data yang tersimpan dalam sistem.

### Terukur

Produktivitas teknisi dapat dibandingkan dengan target yang telah ditentukan.

### Terintegrasi

Absensi, lokasi, pekerjaan, target, monitoring, dan laporan berada dalam satu sistem.

### Mudah Dilaporkan

Data dapat digunakan untuk menghasilkan laporan operasional.

---

# 🏗️ Pengembangan Selanjutnya

SIMPATI masih dapat dikembangkan lebih lanjut, antara lain:

* Integrasi Google Maps atau OpenStreetMap
* Visualisasi lokasi teknisi pada peta
* Tracking lokasi secara real-time
* Notifikasi pekerjaan
* Notifikasi ketika teknisi tidak mengirim lokasi
* Dashboard statistik yang lebih lengkap
* Filter laporan berdasarkan tanggal
* Filter berdasarkan teknisi
* Filter berdasarkan divisi
* Export Excel
* Export PDF
* Grafik produktivitas
* Riwayat lokasi teknisi
* Sistem approval pekerjaan
* Penilaian kinerja teknisi
* Integrasi dengan sistem internal perusahaan

---

# 🎓 Konteks Pengembangan

Project SIMPATI dikembangkan sebagai bagian dari kegiatan **Kerja Praktik/KPI mahasiswa Informatika** di lingkungan **PT Telkom Indonesia, khususnya Telkom Majene**.

Project ini menerapkan pengetahuan yang diperoleh dalam bidang:

* Rekayasa Perangkat Lunak
* Pemrograman Web
* Basis Data
* Perancangan Sistem Informasi
* Pengembangan Aplikasi
* Authentication & Authorization
* REST/HTTP request
* Geolocation
* Manajemen data
* Pengujian sistem

---

# 👨‍💻 Developer

**Shabir**

Mahasiswa Program Studi Informatika
Universitas Sulawesi Barat

Project:

**SIMPATI — Sistem Informasi Monitoring Produktivitas dan Absensi Teknisi**

---

# 📄 Lisensi

Project ini dikembangkan untuk kebutuhan pembelajaran, Kerja Praktik/KPI, pengembangan sistem, dan dokumentasi akademik.

Penggunaan, pengembangan, dan distribusi project dapat disesuaikan dengan ketentuan dan izin dari pihak terkait.

---

# ⭐ SIMPATI

**Sistem Informasi Monitoring Produktivitas dan Absensi Teknisi**

> Digitalisasi monitoring teknisi melalui integrasi absensi, lokasi, pekerjaan, produktivitas, monitoring, dan laporan dalam satu sistem.

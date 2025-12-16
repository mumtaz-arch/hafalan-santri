# Aplikasi Penghafalan Al-Qur'an untuk Santri (QurHafSan)

## Daftar Isi
1. [Gambaran Umum](#gambaran-umum)
2. [Tujuan dan Latar Belakang](#tujuan-dan-latar-belakang)
3. [Arsitektur Aplikasi](#arsitektur-aplikasi)
4. [Fitur Utama](#fitur-utama)
5. [Teknologi yang Digunakan](#teknologi-yang-digunakan)
6. [Struktur Proyek](#struktur-proyek)
7. [Proses Pengembangan](#proses-pengembangan)
8. [Diagram Sistem](#diagram-sistem)
9. [Petunjuk Kontribusi](#petunjuk-kontribusi)

## Gambaran Umum

Penghafalan Al-Qur'an untuk Santri (QurHafSan) adalah aplikasi web fullstack yang dirancang khusus sebagai sistem kontrol dan manajemen penghafalan Al-Qur'an bagi alumni santri, khususnya mereka yang sedang menjalani Program Kerja Lapangan (PKL) atau yang berada jauh dari pesantren.

Aplikasi ini menyediakan platform yang memungkinkan pengguna untuk:
- Merekam dan mengelola penghafalan Al-Qur'an yang telah dikuasai
- Memantau perkembangan penghafalan
- Membaca dan memahami arti serta tafsir ayat-ayat
- Mengelola jadwal dan target hafalan
- Menerima notifikasi dan pengingat

## Tujuan dan Latar Belakang

### Permasalahan Latar Belakang

Banyak alumni santri menghadapi tantangan dalam melanjutkan penghafalan Al-Qur'an ketika mereka berada jauh dari lingkungan pesantren, terutama ketika menjalani PKL (Praktik Kerja Lapangan). Faktor-faktor umum meliputi:

1. **Akses Mentor Terbatas**: Santri tidak memiliki akses langsung ke ustadz atau guru untuk mengoreksi hafalan
2. **Lingkungan Berbeda**: Lingkungan PKL seringkali tidak memungkinkan membaca Al-Qur'an secara intensif
3. **Permasalahan Manajemen Waktu**: Kesulitan mengatur waktu antara tanggung jawab kerja dan ibadah
4. **Kehilangan Motivasi**: Kurangnya dukungan komunitas dan sistem pengawasan

### Tujuan Aplikasi

1. **Mempertahankan dan Meningkatkan Hafalan**: Membantu santri tetap aktif dalam menghafal dan mengulang hafalan meskipun berada jauh dari pesantren
2. **Mandiri dan Fleksibel**: Menyediakan platform yang dapat diakses kapan saja dan di mana saja
3. **Monitoring dan Evaluasi**: Menyediakan sistem pelacakan kemajuan yang transparan dan mudah dipahami
4. **Pemahaman yang Ditingkatkan**: Mengintegrasikan arti dan tafsir untuk memperdalam pemahaman tentang hafalan
5. **Membangun Konsistensi**: Membantu santri menjaga konsistensi dalam rutinitas menghafal

## Arsitektur Aplikasi

Aplikasi ini dibangun dengan arsitektur microservices yang terdiri dari beberapa komponen utama:

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Frontend      │    │   Backend       │    │   Database      │
│   (React/Laravel)│    │   (Laravel API) │    │   (MySQL/Redis) │
│                 │    │                 │    │                 │
│   - Dashboard   │◄──►│   - API Routes  │◄──►│   - Users       │
│   - Quran Text  │    │   - Auth &      │    │   - Quran       │
│   - Progress    │    │     Authorization│    │   - Progress    │
│     Tracking    │    │   - Quran       │    │   - Sessions    │
│   - Settings    │    │     Management  │    │   - Notifications│
└─────────────────┘    └─────────────────┘    └─────────────────┘
         │                       │                       │
         └───────────────────────┼───────────────────────┘
                                 │
                    ┌─────────────────┐
                    │   Storage &     │
                    │   CDN (Public)  │
                    │                 │
                    │   - Images      │
                    │   - Documents   │
                    │   - Backup      │
                    └─────────────────┘
```

### Komponen Arsitektur:

1. **Frontend (Sisi Klien)**: Antarmuka pengguna dibangun dengan React.js atau Laravel Blade
2. **Backend (Sisi Server)**: API berbasis Laravel menangani logika bisnis dan otentikasi
3. **Database**: Sistem penyimpanan data utama (MySQL) dan cache (Redis)
4. **Storage & CDN**: Penyimpanan file statis seperti gambar, dokumen, dan aset lainnya

## Fitur Utama

### 1. Sistem Otentikasi
- Pendaftaran dan login pengguna
- Verifikasi email
- Reset kata sandi
- Sesi otentikasi yang aman

### 2. Tampilan Teks Al-Qur'an
- Tampilan teks ayat Al-Qur'an
- Pemilihan surat dan halaman
- Fitur pencarian dalam Al-Qur'an
- Tampilan teks yang mudah dibaca

### 3. Sistem Manajemen Hafalan
- Input hafalan baru
- Pengelompokan surat dan halaman
- Sistem penilaian dan umpan balik
- Fitur review (muraja'ah)

### 4. Dashboard Monitoring
- Visualisasi kemajuan hafalan
- Grafik dan statistik perkembangan
- Target dan pencapaian
- Riwayat aktivitas

### 5. Fitur Edukasi
- Arti dan tafsir dalam bahasa Indonesia
- Penjelasan konteks surat
- Referensi ilmiah dan tambahan

### 6. Pengingat & Notifikasi
- Pengingat harian
- Notifikasi pencapaian
- Jadwal hafalan pribadi

## Teknologi yang Digunakan

### Backend
- **Framework**: Laravel (PHP)
- **Database**: MySQL
- **Cache**: Redis
- **Otentikasi**: Laravel Sanctum atau JWT
- **Antrian**: Laravel Queue
- **Dokumentasi API**: Swagger/OpenAPI

### Frontend
- **Framework**: React.js atau Laravel Blade
- **UI Library**: Bootstrap atau Tailwind CSS
- **Manajemen State**: Redux (jika menggunakan React)
- **Penampil Teks**: Komponen React untuk menampilkan teks Al-Qur'an

### Infrastruktur
- **Server**: Apache/Nginx
- **Version Control**: Git
- **Deployment**: Docker (opsional)
- **CDN**: CloudFlare atau CDNJS

## Struktur Proyek

```
qurhafsan/
├── app/                    # Logika aplikasi inti
│   ├── Http/              # Controller, Middleware, Request
│   ├── Models/            # Model Eloquent
│   ├── Services/          # Layanan logika bisnis
│   └── Helpers/           # Fungsi pembantu
├── config/                # File konfigurasi
├── database/              # Migration, Seeds, Factory
├── public/                # Aset publik
├── resources/             # View, komponen, aset
│   ├── js/               # File JavaScript
│   ├── sass/             # Stylesheet SCSS
│   └── views/            # Template Blade
├── routes/                # Definisi rute
├── storage/               # Penyimpanan file
├── tests/                 # File tes
├── vendor/                # Dependensi Composer
├── node_modules/          # Dependensi NPM
├── .env                   # Variabel lingkungan
├── .gitignore
├── artisan                # CLI Laravel
├── composer.json
├── package.json
├── phpunit.xml
└── README.md
```

## Proses Pengembangan

### Persyaratan Sistem
- PHP >= 8.0
- Composer
- Node.js >= 14
- NPM atau Yarn
- MySQL >= 8.0
- Redis (opsional tetapi direkomendasikan)

### Instalasi Awal

1. **Clone repositori**:
```bash
git clone <repository-url>
cd qurhafsan
```

2. **Instal dependensi**:
```bash
composer install
npm install
```

3. **Konfigurasi lingkungan**:
```bash
cp .env.example .env
php artisan key:generate
```

4. **Konfigurasi database**:
Edit file `.env` dan sesuaikan konfigurasi database Anda:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qurhafsan
DB_USERNAME=user_anda
DB_PASSWORD=kata_sandi_anda
```

5. **Jalankan migrasi database**:
```bash
php artisan migrate --seed
```

6. **Jalankan server pengembangan**:
```bash
php artisan serve
npm run dev
```

### Pengembangan Lanjutan

#### Menambahkan Model Baru
```bash
php artisan make:model QuranSurah -mcr
```
Perintah ini akan membuat model, migration, dan controller sekaligus.

#### Menambahkan Rute Baru
Tambahkan ke file `routes/api.php` atau `routes/web.php` sesuai kebutuhan:
```php
Route::apiResource('surahs', QuranSurahController::class);
```

#### Menjalankan Tes
```bash
php artisan test
# atau
./vendor/bin/phpunit
```

#### Build Aset
```bash
npm run build
# atau untuk mode watch
npm run dev
```

## Diagram Sistem

### Diagram Use Case
```
              Pengguna
                │
        ┌───────▼────────┐
        │  Registrasi    │
        └───────┬────────┘
                │
        ┌───────▼────────┐
        │    Login       │
        └───────┬────────┘
                │
        ┌───────▼────────┐
    ┌───► Baca Al-Qur'an │
    │   └───────┬────────┘
    │           │
    │   ┌───────▼────────┐
    │   │ Input Hafalan  │
    │   └───────┬────────┘
    │           │
    │   ┌───────▼────────┐
    │   │ Lihat Progres  │
    │   └───────┬────────┘
    │           │
    │   ┌───────▼────────┐
    │   │  Muraja'ah     │
    │   └────────────────┘
    │
    └───► Lihat Statistik│
        └────────────────┘
```

### Diagram Alir Data
```
Pengguna (Frontend) ──────► Backend (Laravel API)
       │                           │
       │  Interaksi UI             │  Validasi & Pemrosesan
       │                           │
       ▼                           ▼
   Komponen React        Controller & Layanan
       │                           │
       │  Manajemen State          │  Logika Bisnis
       │                           │
       ▼                           ▼
   Redux/Axios              Model Eloquent
       │                           │
       │  Permintaan HTTP          │  Query Database
       │                           │
       ▼                           ▼
   Panggilan API           MySQL/Redis
```

### Diagram Arsitektur MVC
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   View (Frontend)│    │   Controller   │    │    Model        │
│                 │    │                 │    │                 │
│   - Dashboard   │◄──►│   - Quran       │◄──►│   - User        │
│   - Quran Text  │    │     Controller  │    │   - QuranSurah  │
│   - Progress    │    │   - Auth        │    │   - QuranAyah   │
│     Monitoring  │    │     Controller  │    │   - Progress    │
│   - Settings    │    │   - Progress    │    │     Tracking    │
└─────────────────┘    │     Controller  │    │   - Session     │
                       └─────────────────┘    └─────────────────┘
```

## Panduan Kontribusi

### Standar Penulisan Kode
- Gunakan PSR-12 untuk standar PHP
- Gunakan ESLint dan Prettier untuk JavaScript
- Gunakan camelCase untuk nama fungsi JavaScript
- Gunakan snake_case untuk nama method PHP
- Sediakan komentar dan dokumentasi yang jelas

### Alur Kerja Kontribusi
1. Fork repositori
2. Buat branch baru (`git checkout -b feature/nama-fitur`)
3. Commit perubahan (`git commit -m 'Tambah fitur: nama fitur'`)
4. Push ke branch (`git push origin feature/nama-fitur`)
5. Buat Pull Request

### Pengujian
- Pastikan semua tes unit lulus sebelum membuat PR
- Tambahkan tes untuk fitur baru
- Lakukan pengujian manual sebelum pengiriman

## Kesimpulan

Aplikasi QurHafSan dirancang sebagai solusi komprehensif bagi alumni santri yang ingin melanjutkan penghafalan Al-Qur'an meskipun berada jauh dari pesantren. Dengan pendekatan teknologi modern dan desain yang berfokus pada pengguna, aplikasi ini diharapkan dapat membantu mempertahankan dan meningkatkan kualitas penghafalan Al-Qur'an di antara alumni santri.

Dengan sistem manajemen hafalan terintegrasi, fitur monitoring komprehensif, dan akses ke sumber daya pendidikan lengkap, aplikasi ini berkontribusi pada pembelajaran Al-Qur'an yang berkelanjutan dan mandiri.
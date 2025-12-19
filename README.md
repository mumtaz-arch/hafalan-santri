# Sistem Kontrol Hafalan Santri MAKN Ende

## 📚 Deskripsi Project

**Sistem Kontrol Hafalan Santri MAKN Ende** adalah aplikasi web berbasis Laravel yang dirancang untuk mendigitalisasi proses penyetoran, pencatatan, dan pemantauan hafalan Al-Qur'an santri di Madrasah Aliyah Kejuruan Negeri Ende.

### Fitur Utama:
- 📱 **Santri**: Merekam/upload hafalan, melihat riwayat, dan tracking progress
- 👨‍🏫 **Ustad/Admin**: Review hafalan, memberikan nilai & feedback, kelola data master
- 🎙️ **Voice Recording**: Rekam suara langsung di browser atau upload file audio
- 📊 **Dashboard**: Monitoring real-time status hafalan per santri
- 📄 **Export**: Cetak laporan hafalan dalam format PDF
- 👤 **Avatar Inisial**: Menampilkan avatar dengan inisial nama jika tidak ada foto profil
- 🏷️ **Prefix Otomatis**: Nama ustad otomatis ditampilkan dengan prefix "Ustad "
- 🎨 **UI Konsisten**: Penyesuaian tampilan dan warna islamic-green sepanjang aplikasi
- 🔐 **Keamanan**: Validasi password konsisten dan fitur keamanan tambahan
- 📝 **Profile Lengkap**: Edit profil lengkap termasuk NISN dan kelas
- 📋 **Detail Submission**: Tampilan detail submission yang dinamis dan informatif

---

## 🔧 Prasyarat

Sebelum menjalankan project, pastikan sudah terinstall:

- **PHP** >= 8.1
- **Composer** (dependency manager PHP)
- **Node.js** & **npm** (untuk asset front-end)
- **MySQL** atau database lainnya
- **Git** (untuk version control)

---

## 📦 Instalasi & Setup

### 1. Clone Project
```bash
git clone https://github.com/mumtaz-arch/hafalan-santri.git
cd hafalan-santri
```

### 2. Install Dependencies PHP
```bash
composer install
```

### 3. Copy File Environment
```bash
cp .env.example .env
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Konfigurasi Database
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hafalan_santri
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Jalankan Migrasi Database
```bash
php artisan migrate
```

### 7. (Opsional) Seeding Data
```bash
php artisan db:seed
```

### 8. Install Dependencies Node.js
```bash
npm install
```

### 9. Build Assets
```bash
npm run build
```

Atau untuk development dengan auto-reload:
```bash
npm run dev
```

---

## 🚀 Menjalankan Project

### Development Server
```bash
php artisan serve
```

Project akan berjalan di: `http://localhost:8000`

### Dengan File Watcher (Hot Reload)
Di terminal terpisah, jalankan:
```bash
npm run dev
```

---

## 👤 Akun Demo

Setelah seeding, Anda bisa login dengan:

**Ustad/Admin:**
- Email: `ustad@example.com`
- Password: `password`

**Santri:**
- Email: `santri@example.com`
- Password: `password`

---

## 📁 Struktur Folder

```
benar - Copy/
├── app/
│   ├── Http/Controllers/      # Controller aplikasi
│   ├── Models/                # Model database
│   ├── Exceptions/            # Exception handling
│   └── Providers/             # Service providers
├── routes/                    # Route definitions
├── resources/
│   ├── views/                 # Blade templates
│   ├── css/                   # CSS files
│   └── js/                    # JavaScript files
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/               # Database seeders
│   └── factories/             # Model factories
├── config/                    # Configuration files
├── storage/                   # File storage
├── public/                    # Public assets
└── tests/                     # Test files
```

---

## 🔑 Role & Permission

### Santri
- ✅ Upload/Rekam hafalan
- ✅ Lihat riwayat hafalan
- ✅ Tracking progress
- ✅ Lihat feedback dari ustad
- ✅ Edit profil lengkap (termasuk NISN dan kelas)
- ✅ Lihat detail submission dengan informasi reviewer

### Ustad/Admin
- ✅ Review hafalan santri
- ✅ Memberikan nilai & feedback
- ✅ Kelola data santri
- ✅ Kelola target hafalan
- ✅ Export laporan
- ✅ Lihat dan verifikasi akun ustad baru
- ✅ Akses ke semua fitur administrasi

---

## 📝 Environment Variables Penting

```env
APP_NAME=HafalanSantri
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=hafalan_santri
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
```

---

## 🧪 Testing

Jalankan unit tests:
```bash
php artisan test
```

Jalankan feature tests:
```bash
php artisan test --filter Feature
```

---

## 📊 Database Diagram

**Users Table:**
- id, name, email, password, role (santri/ustad), nisn, kelas

**Hafalans Table:**
- id, nama_surah, juz, halaman

**Voice Submissions Table:**
- id, user_id (santri), hafalan_id, file_path, status (pending/approved/rejected), reviewed_by (ustad), nilai, feedback

---

## 🐛 Troubleshooting

### Error: "Class 'PDO' not found"
```bash
# Install PHP MySQL extension
# Windows: Edit php.ini dan uncomment: extension=pdo_mysql
# Linux: apt-get install php8.1-mysql
```

### Error: "No supported encrypter found"
```bash
php artisan key:generate
```

### Storage symlink error
```bash
php artisan storage:link
```

### Permission error pada storage/logs
```bash
chmod -R 777 storage/
chmod -R 777 bootstrap/cache/
```

---

## 📞 Informasi Tambahan

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade, Tailwind CSS
- **Audio**: Web Audio API
- **Build Tool**: Vite

---

## 🎨 Update Terbaru

### Desain & UI/UX
- **Avatar User**: Menampilkan avatar dengan inisial nama user jika tidak ada foto profil
- **Prefix Otomatis**: Nama ustad otomatis ditampilkan dengan prefix "Ustad " di semua halaman
- **Pagination Konsisten**: Tampilan pagination disesuaikan dengan tema islamic-green
- **Navbar Konsisten**: Penyesuaian tampilan navbar antara guest dan authenticated user

### Keamanan & Validasi
- **Password Validation**: Validasi password konsisten di semua form (minimal 6 karakter)
- **NISN Unique**: Validasi NISN unik untuk mencegah duplikasi data
- **Session Management**: Penanganan session yang aman dan konsisten

### Fungsionalitas
- **Detail Submission**: Tampilan detail submission yang lebih informatif dan dinamis
- **Edit Profil Lengkap**: Fitur edit profil lengkap termasuk NISN dan kelas untuk santri
- **Verifikasi Ustad**: Fitur verifikasi akun ustad oleh admin

---

## 📄 Lisensi

Project ini dibuat untuk Madrasah Aliyah Kejuruan Negeri Ende.

---

## 👨‍💻 Support

Untuk pertanyaan atau issue, silakan buat issue di repository atau hubungi tim development.

---

**Version**: 1.0.0  
**Last Updated**: Desember 2025

# Panduan Hosting Aplikasi Penghafalan Al-Qur'an QurHafSan di cPanel

## Ikhtisar
Dokumen ini menyediakan panduan langkah-demi-langkah untuk menghosting aplikasi QurHafSan di cPanel, termasuk bagaimana menangani perintah `php artisan storage:link` yang sering menjadi masalah saat deploy di cPanel.

## Prasyarat

### Server Requirements
- PHP 8.1+ (aktifkan ekstensi: PDO, OpenSSL, Mbstring, Tokenizer, XML, Ctype, JSON)
- MySQL 8.0+
- Composer
- Fungsi `symlink()` tidak diblokir oleh hosting
- .htaccess diizinkan

## Langkah-Langkah Deployment

### 1. Upload File Aplikasi
1. Kompres seluruh folder proyek lokal menjadi file ZIP
2. Login ke cPanel hosting Anda
3. Gunakan File Manager untuk mengupload file ZIP ke root directory dokumen (biasanya `public_html` atau folder subdomain)
4. Extract file ZIP ke folder aplikasi Anda

### 2. Konfigurasi Database
1. Di cPanel, buat database baru melalui "MySQL Database"
2. Buat user database dan tetapkan ke database
3. Import struktur database dari file `database/migrations` (jika Anda memiliki file SQL backup) atau
4. Catat detail koneksi database: nama database, username, password, dan host

### 3. Konfigurasi Lingkungan
1. Di folder utama aplikasi, ubah nama file `.env.example` menjadi `.env`
2. Edit file `.env` dan sesuaikan konfigurasi:
   ```
   APP_URL=https://domain-anda.com/path-ke-aplikasi
   APP_ENV=production
   APP_DEBUG=false
   
   DB_CONNECTION=mysql
   DB_HOST=localhost (atau host database dari cPanel)
   DB_PORT=3306
   DB_DATABASE=nama_database_anda
   DB_USERNAME=username_database_anda
   DB_PASSWORD=password_database_anda
   ```

### 4. Install Dependencies
1. Di cPanel, akses Terminal (jika tersedia) atau gunakan SSH
2. Navigasi ke folder aplikasi Anda
3. Jalankan perintah:
   ```bash
   composer install --optimize-autoloader --no-dev
   ```
4. Jika terminal tidak tersedia, beberapa cPanel hosting menyediakan fitur "Terminal" atau Anda harus menghubungi dukungan hosting untuk menjalankan perintah ini.

### 5. Generate Application Key
1. Dari terminal cPanel atau melalui fitur "Execute Command":
   ```bash
   php artisan key:generate
   ```

### 6. **Menjalankan Perintah `php artisan storage:link` di cPanel (Jawaban dari Pertanyaan Anda)**

#### Metode 1: Menggunakan Terminal di cPanel
Jika hosting Anda menyediakan terminal, Anda dapat menjalankan perintah langsung:
```bash
php artisan storage:link
```

#### Metode 2: Alternatif Manual (Jika Terminal Tidak Tersedia)
Jika Anda tidak bisa menjalankan perintah `storage:link`, Anda bisa membuat link simbolik secara manual:

1. Gunakan File Manager di cPanel
2. Navigasi ke folder `public` dalam aplikasi Anda
3. Cari folder `storage` yang harus dibuat sebagai link
4. Hapus folder `storage` (jika sudah ada)
5. Buat link simbolik secara manual dengan membuat file `.htaccess` di folder `public` dengan isi:
   ```
   Options -Indexes
   Options +FollowSymLinks
   
   <IfModule mod_rewrite.c>
       RewriteEngine On
   
       # Redirect storage folder
       RewriteRule ^storage/(.*)$ /path-ke-aplikasi/storage/app/public/$1 [L,NC]
   </IfModule>
   ```

#### Metode 3: Alternatif Lain jika Metode di Atas Tidak Bekerja
Beberapa hosting cPanel tidak mengizinkan symlink di direktori publik. Dalam kasus ini:

1. Salin isi folder `storage/app/public` ke folder `public/storage` secara manual melalui File Manager
2. Perbarui rute dalam aplikasi Anda dengan menambahkan kode berikut di file `AppServiceProvider.php`:
   ```php
   if (app()->environment('production')) {
       $this->app['url']->forceScheme('https');
   }
   ```

### 7. Jalankan Migrasi Database
1. Dari terminal cPanel:
   ```bash
   php artisan migrate --force
   ```
2. Jika perlu, tambahkan data awal:
   ```bash
   php artisan db:seed --force
   ```

### 8. Set Izin File
1. Di File Manager cPanel, set izin folder berikut ke 775:
   - `storage/`
   - `bootstrap/cache/`
2. Set izin file `.env` ke 644

### 9. Kompilasi Aset Frontend
Jika Anda menggunakan Node.js dan NPM:
1. Di terminal cPanel (jika tersedia):
   ```bash
   npm install --production
   npm run build
   ```

## Konfigurasi Server Web

### Untuk Apache (.htaccess)
Pastikan file `.htaccess` di folder `public` sudah ada dan berisi:
```
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

## Optimasi Cache
Setelah semua file diunggah dan konfigurasi selesai:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## Penanganan Khusus untuk Fitur Upload Audio

### 1. Konfigurasi PHP
Pastikan hosting mendukung:
- Upload file hingga 35MB (konfigurasi `upload_max_filesize` dan `post_max_size`)
- Ekstensi audio (mp3, wav, m4a, ogg) tidak diblokir

### 2. Konfigurasi Keamanan
- Folder `storage/app/public/voice_recordings` harus dapat ditulis
- File audio yang diupload harus dipindai untuk keamanan

## Troubleshooting Umum

### 1. Link Storage Tidak Berfungsi
- Pastikan fungsi `symlink()` tidak dinonaktifkan oleh hosting
- Jika tidak bisa, gunakan metode alternatif seperti penjelasan di atas

### 2. Permission Error
- Pastikan folder `storage` dan `bootstrap/cache` memiliki izin yang benar (775)
- Pastikan ownership file benar

### 3. URL Tidak Bekerja
- Pastikan file `.htaccess` ada di folder `public`
- Periksa konfigurasi `APP_URL` di file `.env`

### 4. Database Connection Error
- Periksa detail konfigurasi koneksi database
- Pastikan host database benar (biasanya `localhost`)

## Konfigurasi Cron Job (Jika Diperlukan)
Jika aplikasi menggunakan queue atau scheduled commands:
1. Di cPanel, buka "Cron Jobs"
2. Tambahkan perintah:
   ```
   * * * * * cd /path-to-your-app && php artisan schedule:run >> /dev/null 2>&1
   ```

## Pengujian Setelah Deployment

### 1. Akses Aplikasi
- Kunjungi URL aplikasi Anda
- Pastikan halaman utama dimuat tanpa error

### 2. Uji Fungsionalitas Utama
- Login dengan akun uji
- Uji upload file audio
- Periksa apakah file upload ditampilkan dengan benar
- Uji fitur CRUD hafalan

### 3. Periksa Error Log
- Cek file `storage/logs/laravel.log` melalui File Manager
- Pastikan tidak ada error kritis

## Pemeliharaan Setelah Deployment

### 1. Backup Rutin
- Backup database secara berkala
- Backup folder aplikasi penting

### 2. Monitoring
- Periksa log aplikasi secara berkala
- Monitor penggunaan storage untuk file audio
- Periksa kinerja aplikasi

## Rekomendasi Keamanan

### 1. Proteksi Folder Sensitif
- Pastikan folder `storage`, `config`, `database` tidak dapat diakses langsung dari web

### 2. Update Aplikasi
- Pastikan Anda menggunakan versi Laravel terbaru
- Update dependensi secara berkala

### 3. Konfigurasi .env
- Jangan pernah menyimpan file `.env` di versi kontrol umum
- Set `APP_DEBUG=false` di lingkungan produksi

## Kesimpulan

Deployment aplikasi QurHafSan di cPanel memerlukan perhatian khusus terhadap konfigurasi storage karena fitur upload audio yang penting. Perintah `php artisan storage:link` sering kali menjadi kendala utama, jadi gunakan metode alternatif jika perintah tidak bisa dijalankan secara langsung.

Pastikan untuk menguji semua fitur penting setelah deployment, terutama fungsionalitas upload audio, karena ini adalah fitur inti dari aplikasi QurHafSan.
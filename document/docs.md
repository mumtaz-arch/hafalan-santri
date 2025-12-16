# Dokumentasi Aplikasi: Aplikasi Penghafalan Santri MAKN Ende

## Gambaran Umum
Aplikasi Penghafalan Santri adalah sistem berbasis web untuk melacak dan mengelola penghafalan Al-Qur'an bagi santri di MAKN Ende. Aplikasi ini memungkinkan santri untuk mengirimkan rekaman audio hafalan mereka, yang kemudian akan direview oleh guru (ustad) yang dapat menyetujui, menolak, atau memberikan umpan balik terhadap pengiriman tersebut.

## Fitur-fitur

### Sistem Otentikasi
- Kontrol akses berbasis peran (Santri, Ustad, Admin)
- Fungsi login dan registrasi
- Redirect yang tepat berdasarkan peran pengguna
- Fungsi reset kata sandi

### Manajemen Hafalan
- Operasi CRUD untuk mengelola catatan hafalan
- Pelacakan surat dan ayat
- Fungsi pagination dan pencarian
- Diorganisir berdasarkan nomor surat

### Sistem Pengiriman Suara
- Perekaman audio langsung di browser
- Dukungan upload file (mp3, wav, m4a, ogg)
- Mencegah pengiriman duplikat untuk hafalan yang telah disetujui
- Memeriksa keberadaan pengiriman yang menunggu
- Organisasi file otomatis di penyimpanan

### Proses Review
- Guru dapat mereview rekaman yang dikirim
- Fungsi persetujuan/penolakan
- Sistem umpan balik dan penilaian
- Tampilan rinci pengiriman

### Fungsi Ekspor
- Ekspor data santri ke CSV
- Ekspor data pengiriman ke CSV
- Ekspor data perkembangan ke CSV
- Ekspor statistik ke CSV

### Pemutar Audio
- Pemutaran audio dalam browser
- Fungsi pratinjau
- Antarmuka pemutar berbasis modal

## Arsitektur Teknis

### Backend
- Framework Laravel PHP
- Database MySQL
- Penyimpanan file menggunakan facade Storage Laravel
- Middleware berbasis peran untuk kontrol akses

### Frontend
- Template Blade untuk rendering sisi server
- Tailwind CSS untuk styling
- JavaScript Vanilla untuk fungsionalitas sisi klien
- Desain responsif untuk kompatibilitas mobile

### Komponen Utama

#### VoiceSubmissionController
Menangani semua fungsionalitas pengiriman suara termasuk:
- Validasi dan upload file audio
- Pembuatan dan penyimpanan pengiriman
- Proses review
- Penanganan permintaan AJAX

#### Perekaman Audio
- Perekaman berbasis browser menggunakan MediaRecorder API
- Validasi sisi klien yang cocok dengan aturan server
- Penanganan kesalahan dan umpan balik pengguna yang tepat

#### Model Database
- User: Menangani otentikasi dan manajemen peran
- Memorization: Menyimpan catatan hafalan
- VoiceSubmission: Melacak riwayat pengiriman dengan status, umpan balik, dan skor

## Fitur Keamanan
- Perlindungan CSRF
- Kontrol akses berbasis peran
- Validasi upload file
- Rute terlindungi dengan middleware otentikasi
- Pencegahan SQL injection melalui Eloquent ORM

## Endpoint API

### Pengiriman Suara
- GET /voice-submissions: Daftar pengiriman (berbeda-beda berdasarkan peran)
- POST /voice-submissions: Buat pengiriman baru
- PUT /voice-submissions/{id}/review: Review pengiriman
- GET /voice-submissions/{id}: Lihat pengiriman tertentu
- DELETE /voice-submissions/{id}: Hapus pengiriman

### Otentikasi
- POST /login: Otentikasi pengguna
- POST /register: Registrasi pengguna
- POST /logout: Logout pengguna

## Spesifikasi Upload File
- Format yang didukung: mp3, wav, m4a, ogg
- Ukuran file maksimum: 35MB
- Lokasi penyimpanan: storage/app/public/voice_recordings
- Pembuatan nama file otomatis dengan timestamp dan ID pengguna

## Penanganan Kesalahan
- Respons JSON yang tepat untuk permintaan AJAX
- Pesan kesalahan deskriptif untuk pengguna
- Logging sisi server untuk debugging
- Validasi sisi klien dengan umpan balik pengguna

## Persyaratan Konfigurasi
- PHP 8.1 atau lebih tinggi
- MySQL 8.0 atau lebih tinggi
- Server web dengan URL rewriting diaktifkan
- Composer untuk manajemen dependensi
- Node.js dan NPM untuk kompilasi aset

## Catatan Pemeliharaan
- Backup rutin database dan file yang diupload
- Pemantauan ruang penyimpanan untuk file audio
- Pemeriksaan log aplikasi secara rutin untuk kesalahan
- Pembaruan dependensi secara berkala

## Penyelesaian Masalah

### Masalah Umum
1. File audio tidak terupload:
   - Periksa ukuran file (maks 35MB)
   - Verifikasi format file didukung
   - Pastikan izin file yang tepat

2. Kesalahan pengiriman AJAX:
   - Verifikasi token CSRF ada
   - Periksa format respons server
   - Konfirmasi penanganan respons JSON yang tepat

3. Masalah perekaman:
   - Pastikan browser mendukung MediaRecorder API
   - Periksa izin mikrofon
   - Verifikasi kompatibilitas browser

## Ringkasan Pembaruan & Perbaikan
Deployment terbaru mencakup perbaikan untuk:
- Penanganan permintaan AJAX untuk respons JSON yang tepat
- Eliminasi kode duplikat
- Duplikasi fungsi JavaScript
- Peningkatan validasi file untuk file WAV yang dihasilkan
- Peningkatan penanganan kesalahan dan umpan balik pengguna
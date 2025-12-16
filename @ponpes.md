# Prompt untuk Pembuatan Web CMS Sekolah Ponpes Pancasila Reo

## Tujuan Proyek
Buatkan web berbasis CMS untuk sekolah bernama "Ponpes Pancasila Reo" yang mana adminnya bisa mengedit semua konten dalam website tanpa perlu coding, menggunakan Laravel sebagai framework backend. Website ini harus memiliki tampilan yang menarik dan profesional, serta mudah dikelola oleh admin.

## Desain dan Tampilan
Website harus memiliki tampilan dan gaya desain yang modern, bersih, dan mencerminkan nuansa pendidikan Islam. Warna-warna yang digunakan sebaiknya menenangkan dan mendukung konsentrasi, seperti hijau, cokelat, atau biru muda dengan aksen kuningan atau emas.

gunakan gaya template ini 
/* Font face declaration for Exo 2 */
@font-face {
  font-family: 'Exo 2';
  src: url('../../fonts/Exo_2/Exo2-VariableFont_wght.ttf') format('truetype');
  font-weight: 100 900;
  font-style: normal;
  font-display: swap;
}

@font-face {
  font-family: 'Exo 2';
  src: url('../../fonts/Exo_2/Exo2-Italic-VariableFont_wght.ttf') format('truetype');
  font-weight: 100 900;
  font-style: italic;
  font-display: swap;
}

:root {
  --islamic-green: #0d5f3c;
  --islamic-light: #e8f5e8;
  --islamic-gradient: linear-gradient(135deg, #0d5f3c 0%, #4ade80 100%);
  --white: #ffffff;
  --gray-50: #f9fafb;
  --gray-100: #f3f4f6;
  --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
  --shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px -1px rgba(0, 0, 0, 0.1);
  --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  --shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
  --radius-sm: 0.375rem;
  --radius: 0.5rem;
  --radius-lg: 0.75rem;
  --radius-xl: 1rem;
}

## Fitur-fitur Utama

### 1. Landing Page
- Halaman depan website yang menampilkan informasi utama sekolah
- Profil sekolah, visi dan misi
- Informasi tentang program pendidikan
- Galeri foto kegiatan
- Testimoni atau berita terbaru
- Informasi kontak

### 2. Dashboard Admin
- Tampilan utama bagi admin setelah login
- Menampilkan keseluruhan data dalam bentuk grafik:
  * Pie chart untuk distribusi siswa berdasarkan kelas
  * Candle chart (atau line chart) untuk perkembangan jumlah siswa per tahun
- Ringkasan statistik: jumlah guru, jumlah siswa, jumlah tenaga pendidik
- Aktivitas terbaru di website

### 3. Pengelolaan Konten (CMS)
- Fitur WYSIWYG editor untuk mengubah konten halaman tanpa coding
- Pengelolaan menu navigasi
- Upload dan kelola foto/gambar
- Pengelolaan berita dan pengumuman
- Pengelolaan halaman statis (profil, visi/misi, kurikulum, dsb)

### 4. Kelola Guru dan Tenaga Kependidikan
- Form tambah/edit/hapus data guru dan tenaga kependidikan
- Upload foto profil
- Informasi lengkap (nama, nip, mata pelajaran, pendidikan terakhir, dll)
- Filter dan pencarian data

### 5. Kelola Siswa
- Form tambah/edit/hapus data siswa
- Upload foto profil
- Data akademik dan informasi orang tua
- Kelola kelas dan kategorisasi siswa
- Catatan: Gunakan 25 data dummy siswa
- Siswa tidak bisa registrasi sendiri, hanya bisa login untuk fitur CBT

### 6. CBT (Computer-Based Testing) untuk Ujian
- Sistem ujian berbasis komputer untuk siswa
- Guru bisa mengupload file soal ujian dengan mudah
- Format soal bisa pilihan ganda, essay, atau campuran
- Timer untuk ujian
- Sistem penilaian otomatis
- Riwayat ujian dan nilai untuk siswa
- Fitur review jawaban selama ujian berlangsung
- Mode ujian simulasi dan ujian resmi
- Laporan hasil ujian untuk guru dan siswa

### 7. Login Siswa
- Siswa hanya bisa login untuk mengerjakan soal ujian
- Tidak bisa register sendiri
- Fitur reset password
- Dashboard sederhana untuk siswa (hasil ujian, jadwal ujian, dll)

## Teknologi dan Packages yang Disarankan

### Backend (Laravel)
- Laravel 10.x atau versi terbaru
- Laravel Sanctum (untuk API authentication)
- Laravel Excel (untuk import/export data)
- Laravel Charts (untuk membuat grafik di dashboard)

### Frontend
- Laravel Livewire atau Inertia.js (untuk interaksi dinamis)
- Tailwind CSS atau Bootstrap 5 (untuk styling)
- Chart.js atau ApexCharts (untuk grafik dashboard)
- CKEditor 5 atau TinyMCE (untuk WYSIWYG editor)
- Alpine.js (jika menggunakan Livewire untuk interaksi frontend ringan)

### Pengelolaan File
- Laravel Storage (untuk upload file soal dan gambar)
- Intervention Image (untuk manipulasi gambar)

### Admin Panel
- Laravel Nova atau Backpack for Laravel (jika ingin admin panel yang siap pakai)
- Atau bisa buat custom admin panel dengan Laravel

### Database
- MySQL atau PostgreSQL

### Deployment
- Vite (untuk build asset modern)
- Composer (untuk dependency management)

## Fitur Tambahan yang Disarankan
- Sistem backup database otomatis
- Fitur export data ke PDF/Excel
- Sistem notifikasi untuk pengumuman penting
- Responsive design untuk mobile
- SEO friendly (meta tags, sitemap)
- Sistem logging untuk tracking aktivitas
- Multi-language support (opsional)

## Aspek Keamanan
- Validasi input yang ketat
- Sanitasi data sebelum disimpan
- Hak akses berjenjang (admin, guru, siswa)
- Enkripsi password
- CSRF protection
- Rate limiting untuk mencegah abuse

## Catatan Khusus
- Buat sistem role-based access control (admin, guru, siswa)
- Untuk student registration, sistem hanya menerima data dari admin
- CBT system harus mencegah cheating sebisa mungkin
- Tampilan harus selaras dengan website hafalan santri
- Gunakan data dummy 25 siswa untuk testing
- Dashboard harus user-friendly dan informatif

Website ini akan menjadi pusat informasi dan administrasi sekolah, meningkatkan efisiensi dan komunikasi antara sekolah, guru, dan siswa.
# SIM Iklim BMKG Kalimantan Barat

Sistem Informasi Iklim (SIM Iklim) adalah platform berbasis web progresif (PWA) dua arah yang dikembangkan untuk BMKG Stasiun Klimatologi Kalimantan Barat. Sistem ini memfasilitasi pengumpulan, validasi, dan diseminasi data iklim harian, peringatan dini cuaca ekstrem secara *real-time*, serta pelaporan anomali cuaca langsung dari masyarakat.

## Fitur Utama

- **Dashboard Publik (Pengunjung)**: Akses data iklim terkini dan statistik historis (rata-rata, minimum, maksimum, deviasi standar) untuk petani, nelayan, dan masyarakat umum Kalimantan Barat.
- **Input Data (Pengamat)**: Antarmuka khusus bagi staf PMG untuk menginput data pengamatan iklim harian.
- **Manajemen & Validasi (Admin)**: Sistem CRUD penuh dan validasi data iklim sebelum dipublikasikan ke masyarakat.
- **Peringatan Dini Real-time**: Admin dapat memicu peringatan cuaca ekstrem yang langsung disiarkan ke pengguna online menggunakan WebSocket (Laravel Reverb) dan Push Notifications (WebPush).
- **Laporan Warga (Citizen Science)**: Masyarakat dapat melaporkan anomali cuaca secara langsung ke BMKG.
- **Progressive Web App (PWA)**: Mendukung instalasi ke *home screen* (layar utama) perangkat seluler dan kapabilitas akses *offline* menggunakan Service Worker dan Cache API.

## Teknologi & Arsitektur

Sistem ini dibangun menggunakan ekosistem pengembangan modern dengan spesifikasi:

- **Bahasa & Framework**: PHP 8.4, Laravel 13
- **Database**: MySQL 8.0+
- **Frontend**: Laravel Blade, Tailwind CSS v4, Vanilla JavaScript
- **Real-time Broadcasting**: Laravel Reverb + Laravel Echo
- **Push Notification**: laravel-notification-channels/webpush (minishlink/web-push)
- **Background Tasks**: Laravel Task Scheduling (Database Queue Driver)
- **Testing**: Pest v4 (TDD)
- **Asset Bundling**: Vite 8

Sistem menggunakan arsitektur monolitik standar Laravel (bukan DDD) dengan autentikasi *native* (tanpa Fortify) dan manajemen *role* berbasis Enum (`admin`, `pengamat`).

## Persyaratan Sistem

- PHP >= 8.4
- MySQL >= 8.0
- Composer 2.x
- Node.js & NPM (untuk Tailwind CSS v4 & Vite)

## Instalasi (Development)

Ikuti langkah-langkah berikut untuk menjalankan sistem di lingkungan pengembangan lokal:

1. **Clone repositori ini**:
   ```bash
   git clone <repository-url>
   cd sim-iklim
   ```

2. **Install dependensi PHP & Node.js**:
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**:
   Duplikat file konfigurasi dan sesuaikan kredensial database Anda.
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Konfigurasi Database & Migrasi**:
   Pastikan Anda telah membuat database (misal: `sim_iklim`) di MySQL. Jalankan migrasi dan seeder untuk membuat akun admin/pengamat awal.
   ```bash
   php artisan migrate --seed
   ```

5. **Generate VAPID Keys untuk Push Notification**:
   Langkah ini wajib untuk mendukung fitur notifikasi web-push.
   ```bash
   php artisan webpush:vapid
   ```

6. **Jalankan Server Lokal & Reverb**:
   Anda memerlukan beberapa terminal untuk menjalankan seluruh ekosistem lokal.
   ```bash
   # Terminal 1: Laravel Development Server
   php artisan serve

   # Terminal 2: Vite Asset Bundler
   npm run dev

   # Terminal 3: Laravel Reverb (WebSocket Server)
   php artisan reverb:start

   # Terminal 4: Queue Worker (Untuk memproses notifikasi & broadcast)
   php artisan queue:work
   ```

## Testing

Sistem ini diuji secara ketat menggunakan Pest v4.

```bash
# Menjalankan seluruh test suite
php artisan test --compact
```

## Keamanan

- Proteksi CSRF penuh pada seluruh endpoint non-publik.
- Middleware khusus berbasis peran (`EnsureUserHasRole`) untuk membatasi akses Admin dan Pengamat.
- Semua data rentan dan *input* difilter dan divalidasi ketat menggunakan *Form Request validation*.

## Lisensi

Sistem ini dikembangkan secara tertutup (*closed-source*) untuk keperluan internal BMKG Stasiun Klimatologi Kalimantan Barat. Hak Cipta dilindungi.

# HadirIn

HadirIn adalah aplikasi absensi berbasis web yang menggunakan Laravel 11. Aplikasi ini memungkinkan pengguna untuk melakukan absensi dengan GPS dan foto sebagai bukti kehadiran.

## Fitur

- **Autentikasi Pengguna**: Login dan registrasi pengguna.
- **Absensi Berbasis GPS**: Menentukan lokasi pengguna saat melakukan absensi.
- **Absensi dengan Foto**: Mengunggah foto sebagai bukti kehadiran.
- **Riwayat Absensi**: Melihat daftar absensi pengguna.
- **Manajemen Pengguna**: Admin dapat mengelola data pengguna.

## Teknologi yang Digunakan

- **Framework**: Laravel 11
- **Database**: MySQL
- **Frontend**: Blade, Bootstrap, Admin LTE
- **Geolocation**: HTML5 Geolocation API
- **Storage**: Laravel Filesystem untuk menyimpan foto absensi

## Instalasi

1. **Clone repositori**
   ```sh
   git clone https://github.com/rizaru22/absensi.git
   cd absensi/hadirin
   ```
2. **Instal dependensi**
   ```sh
   composer install
   ```
3. **Buat file konfigurasi**
   ```sh
   cp .env.example .env
   ```
4. **Konfigurasi env** di dalam file `.env`
   ```env
   APP_LOCALE=id
   APP_FALLBACK_LOCALE=id

   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=hadirin
   DB_USERNAME=root
   DB_PASSWORD=

   FILESYSTEM_DISK=public
   ```
5. **Generate key dan migrasi database**
   ```sh
   php artisan key:generate
   php artisan migrate
   ```
6. **Jalankan aplikasi**
   ```sh
   php artisan serve
   ```
   Aplikasi akan berjalan di `http://127.0.0.1:8000`

## Cara Menggunakan

1. **Login atau Registrasi** sebagai pengguna.
2. **Izinkan akses lokasi** saat melakukan absensi.
3. **Ambil foto langsung dari aplikasi**.
4. **Simpan absensi** dan pastikan tersimpan di riwayat.

## Lisensi

Proyek ini dirilis di bawah lisensi [MIT](LICENSE).

## Kontribusi

Jika ingin berkontribusi, silakan buat pull request atau hubungi kami melalui GitHub Issues.

---

**Penulis**: Safrizal  
**Email**: rizaru.2.2@gmail.com
**GitHub**: [rizaru22](https://github.com/rizaru22)

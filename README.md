# TP7 DPBO

# Janji
Saya <strong>Muhamad Hasbie Assyattar</strong> dengan <strong>NIM 2508288</strong> mengerjakan Tugas Praktikum 7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

## Desain Kelas
1. **Database.php (config/config.php)**
    - Mengelola koneksi database MySQL menggunakan PHP Data Objects (PDO).
    - Mengonfigurasi `ERRMODE_EXCEPTION` untuk penanganan error dan mematikan `EMULATE_PREPARES` agar query prepared statement dieksekusi secara aman (mencegah SQL Injection).
2. **Customer.php (class/Customer.php)**
    - Kelas entitas yang merepresentasikan tabel `customers`.
    - Mengenkapsulasi data penyewa (`nama`, `no_telp`, `nik`, `ttg`) dengan atribut private serta getter & setter.
    - Menyediakan method CRUD: `create()`, `readAll()`, `readById()`, `update()`, dan `delete()`.
3. **Camera.php (class/Camera.php)**
    - Kelas entitas yang merepresentasikan tabel `cameras`.
    - Mengenkapsulasi data inventaris kamera (`merek`, `jenis`, `tipe`, `harga`, `status`).
    - Menyediakan method CRUD: `create()`, `readAll()`, `readById()`, `update()`, `delete()`, serta method pendukung `readAvailable()` dan `updateStatus()`.
4. **Rental.php (class/Rental.php)**
    - Kelas transaksi yang merepresentasikan tabel `rentals` (memiliki relasi Foreign Key ke `customers` dan `cameras`).
    - Mengenkapsulasi data transaksi (`id_customer`, `id_camera`, `tgl_sewa`, `tgl_kembali`, `total`, `status_bayar`).
    - Menyediakan method CRUD lengkap dengan query `JOIN` serta mekanisme otomatisasi mutasi status ketersediaan kamera (otomatis berubah menjadi `'Disewa'` saat ada transaksi baru, dan kembali menjadi `'Tersedia'` saat data sewa dihapus).
5. **index.php**
    - Berfungsi sebagai router/controller utama aplikasi web.
    - Menginisialisasi koneksi database, menginstansiasi objek-objek kelas, mengarahkan navigasi halaman, memproses aksi form `POST` dan `GET`, serta menggabungkan view modular.

## Struktur Desain
```
TP7
│   index.php
│   README.md
│   style.css
│
├───class
│       Camera.php
│       Customer.php
│       Rental.php
│
├───config
│       config.php
│
├───database
│       db_tp7.sql
│
└───view
        cameras.php
        customers.php
        footer.php
        header.php
        rentals.php
```

## Anuan Program
Program ini merupakan website sistem informasi rental kamera berbasis PHP Native berorientasi objek (OOP) dengan PDO Prepared Statement:
1. Saat web pertama kali dibuka, pengguna langsung diarahkan ke halaman **Pelanggan** (default). Terdapat navigasi tab di bagian atas untuk berpindah antara menu **Pelanggan**, **Kamera**, dan **Transaksi Rental**.
2. Di menu **Pelanggan**, admin dapat menambahkan data penyewa baru (nama, no telp, NIK, tempat tanggal lahir), melihat tabel seluruh pelanggan, mengedit data, maupun menghapus data pelanggan.
3. Di menu **Kamera**, admin dapat mengelola unit kamera yang disewakan (merek, jenis seperti DSLR/Mirrorless, tipe model, harga sewa per hari, dan status ketersediaan).
4. Di menu **Transaksi Rental**, admin dapat mencatat peminjaman kamera dengan memilih pelanggan dan unit kamera dari dropdown dinamis. Sistem dilengkapi skrip otomatis yang menghitung total biaya berdasarkan selisih hari sewa dikalikan tarif harian unit kamera.
5. Ketika transaksi sewa berhasil ditambahkan, status kamera yang dipilih akan otomatis diperbarui menjadi `'Disewa'`. Jika transaksi rental dihapus, unit kamera terkait akan otomatis kembali berstatus `'Tersedia'`.
6. Seluruh proses manipulasi database (CRUD) pada ketiga tabel menggunakan *Prepared Statement* murni untuk menjamin keamanan dari celah SQL Injection.

## Dokumentasi


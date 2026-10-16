# ☀️ SunTrip Indonesia - Mobile-First Travel & Corporate Outing Portal

Portal Informasi & Etalase Digital Paket Wisata Nusantara dengan **Pendekatan Mobile-First (Prioritas HP)** dan **Sistem Akses Bertingkat (Gated Content)**.

---

## 🌟 Karakteristik & Fitur Unggulan

1. **Desain Mobile-First Tanpa Kesan "AI Slop"**:
   - Nuansa warna mewah tropis (*Tropical Forest Teal* `#0C362B`, *Golden Sun Sand* `#FAF8F5`, dan aksen *Warm Ochre Gold* `#D97706`).
   - Tipografi modern dan bersih (**Plus Jakarta Sans**).
   - Tombol-tombol besar (*thumb-friendly*, tinggi minimal 48px), navigasi bawah (*Bottom App Bar*) persis seperti aplikasi mobile premium.
   - Mode fleksibel di desktop: Dapat dilihat dalam **Mockup Frame HP** atau beralih ke **Mode Layar Lebar**.

2. **Halaman Terbatas (Gated Content - Fitur Utama)**:
   - Pengunjung umum **hanya bisa melihat ringkasan / teaser paket**.
   - Jadwal rundown hari-ke-hari (*day-by-day itinerary*), rincian fasilitas *include/exclude*, dan estimasi biaya per pax **terkunci rapat**.
   - Kotak gated content menampilkan siluet teaser dan form instan 10 detik.

3. **Sistem Registrasi Member Cepat & Ringan**:
   - Meminta 3 data inti: **Nama Lengkap**, **Departemen / Instansi**, dan **Nomor WhatsApp**.
   - Tanpa verifikasi email yang berbelit-belit atau password yang mudah lupa.
   - Tersimpan otomatis di database dan session/cookie mengingat status pengunjung selama 30 hari.

4. **Katalog Paket Wisata Otentik Indonesia**:
   - Labuan Bajo & Komodo Phinisi Liveaboard (3D2N)
   - Bromo Golden Sunrise & Malang Outing Outbound (3D2N)
   - Bali Coastal Paradise & Nusa Penida Island Escape (4D3N)
   - Raja Ampat Pianemo & Misool Coral Wonderland (4D3N)
   - Belitung Island Hopping & Granite Geopark (3D2N)
   - Yogyakarta Heritage, Borobudur & Merapi Lava Tour (3D2N)

5. **Portal Pengelola (Admin Dashboard)**:
   - Mengelola data member pendaftar.
   - Tombol langsung hubungi via WhatsApp untuk setiap pendaftar.
   - **Fitur Ekspor CSV (Excel)** untuk rekap laporan manajemen/HR.
   - Tambah & edit paket tour beserta rincian itinerary hari demi hari.
   - Kelola permintaan custom trip korporat.

6. **Teknologi Super Ringan & Cepat (Zero Bloat)**:
   - Dibangun dengan **Native PHP + SQLite (PDO)**.
   - Tidak memerlukan instalasi database MySQL manual saat pertama kali dijalankan (database `data/suntrip.sqlite` otomatis dibuat dan di-seed).
   - Siap di-upload ke shared hosting / cPanel mana pun tanpa konfigurasi rumit.

---

## 🚀 Cara Menjalankan di Localhost

Buka terminal di folder project ini:
```bash
php -S localhost:8000
```
Lalu buka di browser:
- **Website Utama (Mode Mobile):** `http://localhost:8000`
- **Portal Admin:** `http://localhost:8000/admin/login.php`
  - Username: `admin`
  - Password: `suntrip2026`

---

## 🌐 Cara Upload ke Hosting / cPanel Klien

1. Kompres semua file di dalam folder project ini menjadi file `.zip`.
2. Buka **cPanel File Manager** -> masuk ke folder `public_html`.
3. Upload file `.zip` lalu ekstrak (**Extract**).
4. Pastikan folder `data/` memiliki permission tulis (**0755** atau **0777**) agar SQLite dapat menyimpan data member.
5. Website langsung siap digunakan!

---

## ⚙️ Kustomisasi Kontak & Nomor WhatsApp

Buka file [includes/config.php](file:///c:/Users/USER/OneDrive/Dokumen/web%20projek/SunTrip%20Indonesia/includes/config.php):
- Ganti `WHATSAPP_NUMBER` dengan nomor WhatsApp CS travel Anda (format: `628xxxxxxxxxx`).
- Ganti `OFFICE_EMAIL` dan `OFFICE_ADDRESS` sesuai identitas biro perjalanan Anda.

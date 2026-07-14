# Rencana Implementasi: Mengubah Menu Daftar Program Menjadi Pembelian Tiket Konser

Berdasarkan diskusi kita, seluruh fitur pendaftaran program kursus yang lama (Camp, Offline, Online) akan **dihapus** dari landing page dan dari menu Admin. Fitur utama akan digantikan oleh sistem pembelian **Tiket Konser**.

Akan ada dua pilihan kategori tiket di halaman utama, yaitu **Umum** dan **Member Aktif Brilliant**.

## Kebutuhan Form (Diperbarui)

**Kategori Umum:**
1. Nama lengkap
2. TTL
3. NO hp
4. Jumlah order tiket
5. Total Harga (Akan ditampilkan secara otomatis berdasarkan harga per tiket x jumlah)
6. Foto Bukti Pembayaran / Transfer (Wajib)

**Kategori Member Aktif Brilliant:**
1. Nama lengkap
2. TTL
3. NO hp
4. Jumlah order tiket
5. Total Harga (Akan ditampilkan secara otomatis berdasarkan harga per tiket x jumlah)
6. Foto Bukti Pembayaran / Transfer (Wajib)
7. Foto Bukti Member Aktif (Wajib, misal: kuitansi/dokumen resmi)

*(Catatan: Foto KTP / Kartu Pelajar ditiadakan berdasarkan permintaan terbaru).*

## User Review Required

> Mohon konfirmasi kembali poin-poin berikut sebelum saya mulai mengeksekusi kode secara menyeluruh:
> 1. Berapa nominal harga per tiket untuk **Umum** dan berapa harga per tiket untuk **Member**? Saya butuh angkanya untuk perhitungan *Total Harga* di form.
> 2. Apakah rencana ini sudah tepat dan sesuai dengan ekspektasi terakhir Anda?

## Proposed Changes

---
### 1. Database & Model (Tiket Konser)

Tabel `tiket_konsers` akan menyimpan data pemesan. 

#### [MODIFY/NEW] `database/migrations/xxxx_xx_xx_xxxxxx_create_tiket_konsers_table.php`
Kolom yang dibuat:
- `kategori` (enum: 'umum', 'member')
- `nama_lengkap` (string)
- `ttl` (string)
- `no_hp` (string)
- `jumlah_tiket` (integer)
- `total_harga` (integer) -> Menyimpan total nominal pembayaran.
- `bukti_pembayaran` (string) -> Disimpan ke `storage/app/public/tiket_konser`
- `bukti_member` (string, nullable) -> Disimpan ke `storage/app/public/tiket_konser`

#### [MODIFY/NEW] `app/Models/TiketKonser.php`
- Model untuk tabel `tiket_konsers` dengan *fillable* sesuai kolom di atas.

---
### 2. Routes & Controller (Public & Admin)

#### [MODIFY] `routes/web.php`
- Menghapus _routes_ menu program yang lama dari halaman utama.
- Menambahkan route `GET /tiket-konser` dan `POST /tiket-konser` untuk pengunjung.
- Menambahkan route CRUD khusus admin di dalam grup *middleware* admin (misal: `/admin/tiket-konser`).

#### [NEW] `app/Http/Controllers/TiketKonserController.php` (Public)
- Menangani proses penyimpanan formulir pembelian tiket.
- Menampilkan Pop-Up Sukses (SweetAlert) setelah *submit* berhasil, persis seperti pendaftaran program lama.

#### [NEW] `app/Http/Controllers/Admin/TiketKonserController.php` (Admin)
- Menangani operasi CRUD (Create, Read, Update, Delete) data tiket konser di _dashboard_ Admin.

---
### 3. Views (Tampilan Landing Page & Form)

#### [MODIFY] `resources/views/landingpage.blade.php`
- Mengubah *popup* utama menjadi pilihan tiket: **Umum** dan **Member Aktif Brilliant**.
- Menghilangkan *section* pendaftaran program yang lama (jika ada).

#### [NEW] `resources/views/tiket_konser/create.blade.php`
- Menampilkan form yang secara dinamis menyesuaikan kategori. 
- Jika pengunjung memilih "Member", kolom _upload_ Bukti Member akan muncul dan wajib diisi.
- Menambahkan _script_ JS untuk menghitung secara langsung `Total Harga = Jumlah Tiket x Harga Satuan`.

---
### 4. Admin Panel UI

#### [MODIFY] `config/adminlte.php` (atau file *sidebar* admin)
- Menghapus menu-menu Program Lama (Camp, Online, Offline).
- Menambahkan menu baru: **Data Tiket Konser**.

#### [NEW] `resources/views/admin/tiket_konser/index.blade.php` dll
- Halaman daftar pemesan tiket, halaman detail untuk melihat foto bukti transfer dan bukti member, serta fitur edit status jika diperlukan.

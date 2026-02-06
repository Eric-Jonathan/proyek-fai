Role Utama dan Fitur Masing-masing
🧑‍🏫 1. Dosen
Deskripsi: Pengguna yang mengajukan surat tugas dan melampirkan surat undangan.
Fitur:
🔹 Login / Register (SSO/Email) 
🔹 Dashboard Dosen: melihat status semua surat tugas (Diajukan, Diproses, Disetujui, Ditolak).
🔹 Ajukan Surat Tugas: isi form (tujuan, tanggal kegiatan, tempat, lampirkan surat undangan). 
🔹 Lihat Riwayat Surat Tugas 
🔹 Download Surat Tugas yang Disetujui (PDF) 
🔹 Notifikasi Otomatis (Email/Alert) ketika surat disetujui/ditolak.
ISI SIDEBAR: DASHBOARD, RIWAYAT, AJUKAN SURAT TUGAS, LOGOUT

2. Kaprodi
Deskripsi: Pihak pertama yang memverifikasi pengajuan dosen dalam satu program studi.
Fitur:
🔹 Lihat daftar pengajuan surat tugas dari dosen di prodi-nya 
🔹 Review & ACC / Tolak permohonan 
🔹 Ajukan Surat Tugas : isi form (tujuan, tanggal kegiatan, tempat, lampirkan surat undangan).
🔹 Tambahkan catatan/revisi jika ditolak 
🔹 Histori keputusan
🔹 Forward otomatis ke Dekan setelah ACC 
ISI SIDEBAR: DASHBOARD, LIST PENGAJUAN SURAT, AJUKAN SURAT TUGAS, LOGOUT

👨‍💼 3. Dekan Fakultas (FST / FD)
Deskripsi: Pihak yang memberikan persetujuan akhir untuk surat tugas fakultas.
Fitur:
🔹 Lihat daftar pengajuan surat tugas dari prodi di bawah fakultasnya
🔹 ACC / Tolak surat tugas 
🔹 Dapat membuat surat tugas sendiri (khusus Dekan) → diarahkan langsung ke Rektor untuk tanda tangan, tetapi tetap melalui verifikasi Sekretaris terlebih dahulu. 
🔹 Memberikan tanda tangan digital setelah surat tugas dibuat oleh Sekretaris. 
🔹 Setelah tanda tangan digital, sistem otomatis kirim notifikasi ke Sekretaris Rektor untuk proses pembuatan surat 
ISI SIDEBAR: DASHBOARD, LIST PENGAJUAN SURAT, AJUKAN SURAT TUGAS, LOGOUT

👩‍💼 4. Sekretaris Rektor / Sekretaris Fakultas
Deskripsi: Pusat pembuatan surat dan pengelolaan dokumen resmi kampus.
Fitur Utama:
🔹Melihat daftar surat tugas yang sudah disetujui oleh Dekan. 
🔹Generate surat tugas berdasarkan jenis kegiatan yang dipilih oleh dosen pada form pengajuan (Surat Tugas Biasa{narasumber, peserta, pembicara, dll} / Surat Tugas Assesor BKD) 
🔹Edit Data Surat: Bisa melakukan edit atau perbaikan isi surat tugas dari hasil form dosen sebelum di-generate menjadi PDF final. 
🔹Generate Surat Tugas (PDF): 
   - Gunakan DomPDF untuk hasil surat digital resmi.
   - Nomor surat otomatis diambil dari database (auto_increment), sehingga tidak perlu role BAA.
🔹Meneruskan surat ke Dekan untuk tanda tangan digital (atau ke Rektor jika diperlukan). - 
🔹Histori surat tugas & surat keluar. - Royce
🔹Laporan surat tugas, surat masuk, surat keluar per bulan / fakultas / dosen dalam bentuk diagram / statistic
ISI SIDEBAR: DASHBOARD, LIST PENGAJUAN SURAT, LOGOUT

🏛️ 5. Rektor
Deskripsi: Penandatangan tertinggi dan pemberi otorisasi surat tugas tertentu (khusus surat Dekan atau kegiatan strategis).
Fitur:
🔹 Melihat surat tugas dari Dekan atau surat tugas penting. 
🔹 Memberikan tanda tangan digital (QR Code/eSign). 
🔹 Melihat histori surat tugas fakultas. - Royce
ISI SIDEBAR: DASHBOARD, LIST PENGAJUAN SURAT, LOGOUT

🧾 6. BAU (Biro Administrasi Umum)
Deskripsi: Mengurus stempel digital, transportasi, dan arsip surat tugas.
Fitur:
🔹 Melihat surat tugas yang sudah ditandatangani - Eric
🔹 Validasi & Stempel Digital (upload versi final + QR Code tanda tangan)
🔹 Upload versi final surat tugas yang sudah distempel ke sistem arsip (Google Drive API). 
🔹 Laporan surat tugas, surat masuk, surat keluar per bulan / fakultas / dosen dalam bentuk diagram / statistic 
ISI SIDEBAR: DASHBOARD, LIST PENGAJUAN SURAT, LOGOUT

🛠️ 7. Admin Sistem
Deskripsi: Pengelola akun, role, dan konfigurasi sistem.
Fitur:
🔹 CRUD akun pengguna. 
🔹 Manajemen role & permission (Spatie Laravel Permission). 
🔹 Monitoring log aktivitas (Spatie Activity Log). - Hansen
🔹 Fitur reset nomor surat tahunan dan tiap bulan berubah bagian bulannya (misal setiap Januari, nomor surat kembali ke 001 dan jika bulan Oktober X). - 
ISI SIDEBAR: DASHBOARD, USER, TEMPLATE SURAT, NOMOR SURAT, LOG AKTIVITAS, LOGOUT


Alur system New:
- surat tugas yang dibuat oleh dosen
dosen (create) > kaprodi (view & acc) > sekre (edit) > dekan (view & acc) > BAU (stempel)
- surat tugas yang dibuat oleh dekan untuk dirinya
dekan (create) > sekre (edit) > rektor (view & acc)
 

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Camp - {{ $program->nama ?? 'Dormitory VIP' }}</title>
    
    <!-- Impor Font dari Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Impor Font Awesome untuk Ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <style>
        /* === Gaya Global & Body === */
        body { font-family: 'Poppins', sans-serif; background-color: #f4f7f9; color: #333; margin: 0; padding: 20px; }
        .detail-container { max-width: 900px; margin: 0 auto; background-color: #fff; padding: 20px 30px; border-radius: 16px; box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05); }

        /* === Judul Utama Halaman (BARU) === */
        .main-title-section {
            text-align: center;
            margin-bottom: 20px;
        }
        .main-title-section h1 {
            font-size: 2.5rem; /* Ukuran font lebih besar */
            font-weight: 700;
            color: #333;
            margin: 0;
        }

        /* === Tombol Kembali === */
        .back-button-section {
            margin-bottom: 25px;
            text-align: center; 
        }

        /* === Bagian Galeri Gambar === */
        .gallery-section { margin-bottom: 30px; }
        .gallery-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; }
        .gallery-item img { width: 100%; height: 200px; object-fit: cover; border-radius: 12px; }
        
        /* === Bagian Area Unggulan === */
        .features-section { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .feature-card { border: 1px solid #e0e0e0; padding: 20px; border-radius: 12px; text-align: center; }
        .feature-card h3 { margin: 0 0 10px 0; font-size: 1.1rem; }
        .feature-card p { margin: 0; font-size: 0.9rem; color: #666; }
        
        /* === Bagian Deskripsi === */
        .description-section { margin-bottom: 40px; padding: 25px; background-color: #f8f9fa; border-radius: 12px; border: 1px solid #e9ecef; }
        .description-section h3 { margin-top: 0; margin-bottom: 15px; font-size: 1.4rem; color: #333; }
        .description-section p { margin: 0; line-height: 1.7; color: #555; white-space: pre-wrap; }

        /* === Bagian Harga === */
        .pricing-section { text-align: center; margin-bottom: 40px; }
        /* .pricing-section h2 dihapus karena judul sudah dipindah ke atas */
        .promo-badge { display: inline-block; background-color: #ffc107; color: #333; padding: 6px 15px; border-radius: 50px; font-weight: 600; font-size: 0.9rem; margin-bottom: 25px; }
        .pricing-table table { width: 100%; border-collapse: collapse; border: 1px solid #e9ecef; }
        .pricing-table th, .pricing-table td { padding: 15px; text-align: left; }
        .pricing-table thead { background-color: #e9ecef; }
        .pricing-table tbody tr:nth-child(even) { background-color: #f8f9fa; }
        .pricing-note { font-size: 0.85rem; color: #666; margin-top: 15px; }

        /* === Bagian Fasilitas & Lokasi === */
        .info-section { display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 40px; }
        .info-card { border: 1px solid #e0e0e0; border-radius: 12px; overflow: hidden; }
        .info-header { padding: 15px; color: white; background-color: #6f42c1; }
        .info-header h3 { margin: 0; font-size: 1.2rem; }
        .info-list { list-style: none; padding: 20px; margin: 0; }
        .info-list li { display: flex; align-items: center; gap: 15px; margin-bottom: 15px; }
        .info-list li i { color: #6f42c1; font-size: 1.1rem; width: 20px; text-align: center; }
        
        /* === Bagian CTA & Tombol Umum === */
        .cta-section { text-align: center; }
        .cta-section p { max-width: 500px; margin: 0 auto 20px auto; color: #555; line-height: 1.6; }
        
        .btn { 
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none; padding: 12px 25px; border-radius: 50px; 
            font-weight: 600; margin: 5px; 
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.3s ease;
            border: none; cursor: pointer;
        }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); }
        .btn-primary { background-color: #0d6efd; color: white; }
        .btn-primary:hover { background-color: #0b5ed7; }
        .btn-whatsapp { background-color: #25d366; color: white; }
        .btn-whatsapp:hover { background-color: #1ebe57; }
        .btn-orange { background-color: #fd7e14; color: white; }
        .btn-orange:hover { background-color: #e67300; }
        
        @media (max-width: 768px) {
            body { padding: 10px; }
            .detail-container { padding: 15px; }
            .gallery-grid, .features-section, .info-section { grid-template-columns: 1fr; }
            .main-title-section h1 { font-size: 2rem; }
        }
    </style>
</head>
<body>
    <div class="detail-container">
        
        <!-- JUDUL UTAMA HALAMAN -->
        <section class="main-title-section">
            <h1>{{ $program->nama }}</h1>
        </section>

        <section class="gallery-section">
            <div class="gallery-grid">
                <div class="gallery-item"><img src="{{ asset('upload/camp/' . ($program->thumbnail ?? 'placeholder.jpg')) }}" alt="Thumbnail"></div>
                <div class="gallery-item"><img src="{{ asset('upload/camp/' . ($program->thumbnail ?? 'placeholder.jpg')) }}" alt="Thumbnail"></div>
                <div class="gallery-item"><img src="{{ asset('upload/camp/' . ($program->thumbnail ?? 'placeholder.jpg')) }}" alt="Thumbnail"></div>
            </div>
        </section>
        
        <section class="features-section">
            <div class="feature-card"><h3>Area Relaksasi</h3><p>Area luas untuk bersantai.</p></div>
            <div class="feature-card"><h3>Area Asrama</h3><p>Asrama modern dengan fasilitas.</p></div>
            <div class="feature-card"><h3>Area Belajar</h3><p>Ruang yang nyaman untuk belajar.</p></div>
        </section>

        <section class="pricing-section">
            {{-- Judul H2 sudah dipindahkan ke atas --}}
            <span class="promo-badge">Special Promo Available</span>
            <div class="pricing-table">
                <table>
                    <thead><tr><th>Durasi</th><th>Harga</th></tr></thead>
                    <tbody>
                        @if($program->harga_perhari > 0)<tr><td>Per Hari</td><td>Rp {{ number_format($program->harga_perhari, 0, ',', '.') }}</td></tr>@endif
                        @if($program->harga_satu_minggu > 0)<tr><td>1 Minggu</td><td>Rp {{ number_format($program->harga_satu_minggu, 0, ',', '.') }}</td></tr>@endif
                        @if($program->harga_dua_minggu > 0)<tr><td>2 Minggu</td><td>Rp {{ number_format($program->harga_dua_minggu, 0, ',', '.') }}</td></tr>@endif
                        @if($program->harga_satu_bulan > 0)<tr><td>1 Bulan</td><td>Rp {{ number_format($program->harga_satu_bulan, 0, ',', '.') }}</td></tr>@endif
                        @if($program->harga_dua_bulan > 0)<tr><td>2 Bulan</td><td>Rp {{ number_format($program->harga_dua_bulan, 0, ',', '.') }}</td></tr>@endif
                        @if($program->harga_tiga_bulan > 0)<tr><td>3 Bulan</td><td>Rp {{ number_format($program->harga_tiga_bulan, 0, ',', '.') }}</td></tr>@endif
                    </tbody>
                </table>
            </div>
        </section>

        <section class="info-section">
            <div class="info-card">
                <div class="info-header"><h3>Fasilitas Kami</h3></div>
                <ul class="info-list">
                    @forelse($facilities as $facility)
                        @if(!empty(trim($facility)))
                            <li><i class="fas fa-check-circle"></i><span>{{ trim($facility) }}</span></li>
                        @endif
                    @empty
                        <li><span>Fasilitas belum tercantum.</span></li>
                    @endforelse
                </ul>
            </div>
            <div class="info-card">
                <div class="info-header"><h3>Lokasi Kami (Contoh)</h3></div>
                <ul class="info-list">
                    <li><i class="fas fa-tree"></i><span>1.8km dari Taman Kota</span></li>
                    <li><i class="fas fa-bus"></i><span>1.4km dari Terminal Pare</span></li>
                </ul>
            </div>
        </section>
        
        <section class="cta-section">
            <p>Kirim pesan kepada kami di WhatsApp untuk memesan sekarang! Tersedia tarif mingguan dan bulanan.</p>
            <a href="#" class="btn btn-primary"><i class="fas fa-calendar-check"></i> Booking Camp Sekarang</a>
            <a href="https://wa.me/6281234567890?text=Halo, saya tertarik dengan program '{{ urlencode($program->nama) }}'" class="btn btn-whatsapp"><i class="fab fa-whatsapp"></i> Hubungi Kami</a>
        </section>
         <!-- TOMBOL KEMBALI -->
         <section class="back-button-section">
            <a href="{{ route('camps.index') }}" class="btn btn-orange">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Daftar Camp</span>
            </a>
        </section>
    </div>
</body>
</html>

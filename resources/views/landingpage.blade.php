<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brilliant English Course</title>

    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <script src="{{ asset('js/landingpage.js') }}"></script>
    <script src="{{ asset('js/gallery.js') }}"></script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

    @include('navbar.navbar')


    <section class="carousel" id="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="{{ asset('asset/img/brilliant1.jpg') }}" class="slide active" alt="Slide 1">
                <img src="{{ asset('asset/img/brilliant2.jpg') }}"
                    class="slide" alt="Slide 2">
                <img src="{{ asset('asset/img/brilliant3.jpg') }}" class="slide" alt="Slide 3">
            </div>
            <div class="overlay"></div>
            <div class="carousel-text">
                <h1>BRILLIANT ENGLISH COURSE</h1>
                <p>Tingkatkan kemampuan Bahasa Inggris Anda dan rasakan pengalaman belajar yang berkualitas di Brilliant
                    English Course, tempat di mana potensi Anda menjadi lebih gemilang!</p>
                <a href="#daftar" class="cta-button">DAFTAR SEKARANG</a>
            </div>
            <button class="nav prev">&#10094;</button>
            <button class="nav next">&#10095;</button>

        </div>
    </section>
        <section class="about-us-section" id="tentang">
            <div class="container">
                <h2 class="section-title">TENTANG KAMI</h2>
    
                <div class="about-grid">
                    <div class="about-intro">
                        <h2>Brilliant English Course?</h2>
                        <p>
                            Berlokasi di jantung Kampung Inggris Pare, Brilliant English Course hadir untuk mengubah cara Anda belajar bahasa Inggris. Kami menciptakan sebuah perjalanan belajar yang tidak hanya efektif, tapi juga tak terlupakan, membuat Anda percaya diri dan fasih berbahasa Inggris.
                        </p>
                    </div>
    
                    <div class="features-grid">
                        <div class="feature-item">
                            <div class="icon"><i class="fas fa-comments"></i></div>
                            <h3>Lingkungan Imersif 24/7</h3>
                            <p>Dengan sistem asrama (camp) berbasis "English Area", Anda akan terbiasa berpikir dan berbicara dalam bahasa Inggris setiap hari. Metode ini terbukti mempercepat kelancaran Anda secara signifikan.</p>
                        </div>
    
                        <div class="feature-item">
                            <div class="icon"><i class="fas fa-lightbulb"></i></div>
                            <h3>Metode Belajar Praktis</h3>
                            <p>Kami fokus pada 80% praktik dan 20% teori. Kelas interaktif, simulasi dunia nyata, dan materi yang relevan membuat proses belajar menjadi efektif, anti-bosan, dan menyenangkan.</p>
                        </div>
    
                        <div class="feature-item">
                            <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                            <h3>Tutor Profesional & Suportif</h3>
                            <p>Tutor kami bukan hanya pengajar, tapi juga mentor yang ramah dan berpengalaman. Mereka siap membimbing Anda langkah demi langkah untuk mencapai target belajar Anda.</p>
                        </div>
    
                        <div class="feature-item">
                            <div class="icon"><i class="fas fa-book-open-reader"></i></div>
                            <h3>Program Terstruktur & Komunitas</h3>
                            <p>Pilih program yang sesuai tujuan Anda, mulai dari Speaking, TOEFL, hingga IELTS. Bergabunglah dengan komunitas pembelajar yang solid dan saling mendukung untuk sukses bersama.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="program-section" id="program">
            <div class="container">
                <h2>PILIHAN PROGRAM</h2>
                <p class="section-subtitle">Temukan program yang paling sesuai dengan tujuan Anda dan mulailah perjalanan Anda menjadi fasih berbahasa Inggris bersama kami.</p>
        
                <div class="program-tabs">
                    <button class="tab-button" data-tab="intensif"><i class="fas fa-rocket"></i> Paket Intensif</button>
                    <button class="tab-button active" data-tab="speaking"><i class="fas fa-comments"></i> Speaking & Confidence</button>
                    <button class="tab-button" data-tab="toefl"><i class="fas fa-graduation-cap"></i> TOEFL / IELTS Prep</button>
                    <button class="tab-button" data-tab="grammar"><i class="fas fa-book"></i> Grammar Masterclass</button>
                </div>
        
                <div class="program-content-wrapper">
        
                    <div id="intensif" class="program-detail">
                        <div class="content-text">
                            <h3>Paket Intensif Terpadu</h3>
                            <p class="description">Program terlengkap untuk akselerasi kemampuan bahasa Inggris Anda secara menyeluruh. Menggabungkan semua materi inti dalam satu paket efektif.</p>
                            <ul class="benefits-list">
                                <li><i class="fas fa-check-circle"></i> Kombinasi kelas Speaking, Grammar, dan Vocabulary.</li>
                                <li><i class="fas fa-check-circle"></i> Wajib tinggal di asrama English Area 24/7.</li>
                                <li><i class="fas fa-check-circle"></i> Proyek akhir untuk aplikasi ilmu secara nyata.</li>
                            </ul>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                                <a href="#" class="btn btn-secondary">Lihat program</a>
                            </div>
                        </div>
                        <div class="content-image">
                            <img src="{{ asset('asset/img/brilliant5.jpg') }}" alt="Galeri 18" onclick="openLightbox(this)">
                        </div>
                    </div>
        
                    <div id="speaking" class="program-detail active">
                        <div class="content-text">
                            <h3>Program Speaking & Confidence</h3>
                            <p class="description">Dirancang khusus untuk Anda yang ingin lancar berbicara dalam situasi sehari-hari. Lupakan gugup dan teori rumit, di sini Anda akan langsung praktik!</p>
                            <ul class="benefits-list">
                                <li><i class="fas fa-check-circle"></i> Kelas praktik speaking setiap hari dengan tutor berpengalaman.</li>
                                <li><i class="fas fa-check-circle"></i> Materi percakapan yang relevan dan sering digunakan.</li>
                                <li><i class="fas fa-check-circle"></i> Lingkungan belajar yang suportif dan bebas dari rasa takut salah.</li>
                            </ul>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                                <a href="#" class="btn btn-secondary">Lihat Program</a>
                            </div>
                        </div>
                        <div class="content-image">
                            <img src="{{ asset('asset/img/img1.jpg') }}" alt="Galeri 21" onclick="openLightbox(this)">
                        </div>
                    </div>
        
                    <div id="toefl" class="program-detail">
                        <div class="content-text">
                            <h3>Persiapan TOEFL / IELTS</h3>
                            <p class="description">Raih skor impian Anda dengan program persiapan tes yang terstruktur. Pelajari strategi jitu, latihan soal intensif, dan dapatkan feedback dari ahlinya.</p>
                            <ul class="benefits-list">
                                <li><i class="fas fa-check-circle"></i> Pembahasan semua seksi tes (Reading, Listening, Speaking, Writing).</li>
                                <li><i class="fas fa-check-circle"></i> Simulasi tes (Try Out) berkala untuk mengukur kemajuan.</li>
                                <li><i class="fas fa-check-circle"></i> Tips dan trik untuk memaksimalkan skor Anda.</li>
                            </ul>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                                <a href="#" class="btn btn-secondary">Lihat Program</a>
                            </div>
                        </div>
                        <div class="content-image">
                            <img src="{{ asset('asset/img/img4.jpg') }}" alt="Galeri 4" onclick="openLightbox(this)">
                        </div>
                    </div>
        
                    <div id="grammar" class="program-detail">
                        <div class="content-text">
                            <h3>Grammar Masterclass</h3>
                            <p class="description">Perkuat fondasi bahasa Inggris Anda dengan memahami tata bahasa secara mendalam. Cocok untuk Anda yang ingin meningkatkan akurasi tulisan dan lisan.</p>
                            <ul class="benefits-list">
                                <li><i class="fas fa-check-circle"></i> Penjelasan konsep grammar yang mudah dimengerti.</li>
                                <li><i class="fas fa-check-circle"></i> Latihan soal aplikatif untuk setiap materi.</li>
                                <li><i class="fas fa-check-circle"></i> Analisis kesalahan umum agar tidak terulang kembali.</li>
                            </ul>
                            <div class="action-buttons">
                                <a href="#" class="btn btn-primary">Daftar Sekarang</a>
                                <a href="#" class="btn btn-secondary">Lihat Program</a>
                            </div>
                        </div>
                        <div class="content-image">
                            <img src="{{ asset('asset/img/img1.jpg') }}" alt="Galeri 21" onclick="openLightbox(this)">
                        </div>
                    </div>
        
                </div>
            </div>
        </section>
        
        <script>
            // Menunggu hingga seluruh halaman HTML selesai dimuat
            document.addEventListener('DOMContentLoaded', function() {
        
                // 1. Ambil semua elemen tombol tab dan detail konten
                const tabs = document.querySelectorAll('.program-tabs .tab-button');
                const contents = document.querySelectorAll('.program-detail');
        
                // 2. Tambahkan event listener 'click' untuk setiap tombol tab
                tabs.forEach(tab => {
                    tab.addEventListener('click', () => {
                        // Ambil nilai dari atribut 'data-tab' pada tombol yang diklik
                        // Contoh: 'speaking'
                        const targetId = tab.dataset.tab;
        
                        // --- Proses untuk Tombol Tab ---
                        // Hapus kelas 'active' dari SEMUA tombol
                        tabs.forEach(t => t.classList.remove('active'));
                        // Tambahkan kelas 'active' HANYA pada tombol yang diklik
                        tab.classList.add('active');
        
                        // --- Proses untuk Konten ---
                        // Sembunyikan SEMUA detail konten
                        contents.forEach(content => content.classList.remove('active'));
                        // Tampilkan HANYA konten yang ID-nya sesuai dengan targetId
                        const targetContent = document.getElementById(targetId);
                        if (targetContent) {
                            targetContent.classList.add('active');
                        }
                    });
                });
            });
        </script>
        
        <script>
            // Fungsi untuk membuka lightbox
            function openLightbox(image) {
                const lightbox = document.getElementById('lightbox');
                const lightboxImage = document.getElementById('lightboxImage');
                lightboxImage.src = image.src;
                lightbox.style.display = 'block';
            }
        
            // Fungsi untuk menutup lightbox
            function closeLightbox() {
                const lightbox = document.getElementById('lightbox');
                lightbox.style.display = 'none';
            }
        </script>   



    <section id="galeri" class="gallery">
        <h2>GALLERY</h2>

        <div class="gallery-wrapper" id="galleryWrapper">
            <div class="gallery-container" id="galleryContainer">
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1536104968055-4d61aa56f46a?q=80&w=2574&auto=format&fit=crop"
                        alt="Galeri 1" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=2670&auto=format&fit=crop"
                        alt="Galeri 2" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1517694712202-14dd9538aa97?q=80&w=2670&auto=format&fit=crop"
                        alt="Galeri 3" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1550439062-609e1531270e?q=80&w=2670&auto=format&fit=crop"
                        alt="Galeri 4" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="https://images.unsplash.com/photo-1498050108023-c5249f4df085?q=80&w=2672&auto=format&fit=crop"
                        alt="Galeri 5" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('asset/img/img1.jpg') }}" alt="Galeri 21" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('asset/img/img2.jpg') }}" alt="Galeri 18" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('asset/img/img3.jpg') }}" alt="Galeri 16" onclick="openLightbox(this)">
                </div>
                <div class="gallery-item">
                    <img src="{{ asset('asset/img/img4.jpg') }}" alt="Galeri 4" onclick="openLightbox(this)">
                </div>
            </div>
        </div>
    </section>

   <div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <span class="lightbox-close" onclick="closeLightbox()">x</span>
    <img class="lightbox-content" id="lightboxImg">
</div>



    <section class="contact-section"
        style="background-color: #f7f7f7; padding: 40px 0; display: flex; flex-wrap: wrap; gap: 32px; justify-content: center;">
        <div style="flex: 1 1 400px; min-width: 300px; height: 300px; border: 1px solid #ccc; background: #fff;">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5003.899952911135!2d112.19113927974144!3d-7.75928448127593!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db44d753ad7%3A0xee91fffa177f7176!2sBriliant%20English%20Course%20Camp%2016!5e0!3m2!1sid!2sid!4v1751310522673!5m2!1sid!2sid"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>

        <div id="kontak" class="contact-box"
            style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.04); padding: 24px; flex: 1 1 350px; min-width: 300px;">
            <h2 style="text-align: center;">Hubungi Kami</h2>
            <p style="color: #000;"><strong>Alamat:</strong><br>Jl. Flamboyan No.48, Mulyoasri, Tulungrejo, Kec. Pare, Kabupaten Kediri, Jawa Timur 64212</p>
            <p><strong>Email:</strong><br>
                <a href="mailto:info@kampunginggris.com" class="text-blue-600 hover:underline">info@kampunginggris.com</a>
            </p>
            <div>
                <p class="font-semibold text-gray-700">Sosial Media:</p>
                <p class="text-blue-600">
                    <a href="https://instagram.com/your_instagram" target="_blank" class="hover:underline"
                        style="margin-right: 10px;">
                        <i class="fab fa-instagram" style="margin-right: 5px;"></i>Instagram
                    </a>
                    |
                    <a href="https://facebook.com/your_facebook" target="_blank" class="hover:underline"
                        style="margin-left: 10px;">
                        <i class="fab fa-facebook" style="margin-right: 5px;"></i>Facebook
                    </a>
                </p>
            </div>
        </div>
    </section>

    <footer>
        © 2025 Brilliant English Course. Hak Cipta Dilindungi Oleh Undang-Undang
    </footer>

    <div class="wa-sticky-wrapper" style="position: fixed; bottom: 24px; right: 24px; z-index: 999;">
        <div class="wa-circle-row" style="display: flex; flex-direction: column; gap: 12px;">
            <a href="https://wa.me/6281234567890" class="wa-circle tooltip" target="_blank" style="background: #25d366; border-radius: 50%; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); position: relative;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA" style="width: 32px; height: 32px;">
                <span class="tooltip-text" style="visibility: hidden; background: #333; color: #fff; text-align: center; border-radius: 6px; padding: 6px 12px; position: absolute; right: 70px; top: 50%; transform: translateY(-50%); opacity: 0; transition: opacity 0.2s;">Contact Person 1</span>
            </a>
            <a href="https://wa.me/6289876543210" class="wa-circle tooltip" target="_blank" style="background: #25d366; border-radius: 50%; width: 56px; height: 56px; display: flex; align-items: center; justify-content: center; box-shadow: 0 2px 8px rgba(0,0,0,0.15); position: relative;">
                <img src="https://upload.wikimedia.org/wikipedia/commons/6/6b/WhatsApp.svg" alt="WA" style="width: 32px; height: 32px;">
                <span class="tooltip-text" style="visibility: hidden; background: #333; color: #fff; text-align: center; border-radius: 6px; padding: 6px 12px; position: absolute; right: 70px; top: 50%; transform: translateY(-50%); opacity: 0; transition: opacity 0.2s;">Contact Person 2</span>
            </a>
        </div>
    </div>

    <script>
        // Tooltip effect for WhatsApp buttons
        document.querySelectorAll('.wa-circle.tooltip').forEach(function(el) {
            el.addEventListener('mouseenter', function() {
                const tooltip = el.querySelector('.tooltip-text');
                tooltip.style.visibility = 'visible';
                tooltip.style.opacity = '1';
            });
            el.addEventListener('mouseleave', function() {
                const tooltip = el.querySelector('.tooltip-text');
                tooltip.style.visibility = 'hidden';
                tooltip.style.opacity = '0';
            });
        });

        // Fungsi lightbox sekarang berada di file public/js/gallery.js
    </script>
</body>
</html>

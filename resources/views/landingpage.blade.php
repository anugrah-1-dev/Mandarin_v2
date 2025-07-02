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

    <section class="about" id="tentang">
        <h2>TENTANG KAMI</h2>
        <p>Brilliant English Course adalah salah satu lembaga kursus unggulan di Kampung Inggris Pare yang dikenal
            dengan metode pembelajaran yang efektif, suasana belajar nyaman, serta fasilitas lengkap yang mendukung
            proses belajar Bahasa Inggris dari dasar hingga mahir.</p>
    </section>

    <div class="section-divider-wrapper">
        <div class="section-divider"></div>
    </div>

    <section class="program" id="program">
    <h2>PROGRAM & HARGA</h2>

    <!-- Baris pertama: Murah & Super -->
    <div class="program-row">
        <div class="program-item">
            <h3>Paket Murah Holiday</h3>
            <ul>
                <li>Rp 498.000 / 1 minggu</li>
                <li>Rp 854.000 / 2 minggu</li>
                <li>Biaya Admin: Rp 125.000</li>
            </ul>
        </div>
        <div class="program-item">
            <h3>Paket Super</h3>
            <ul>
                <li>Rp 1.398.000 / 1 bulan</li>
                <li>Rp 2.599.000 / 2 bulan</li>
                <li><strong>Free Biaya Admin</strong></li>
            </ul>
        </div>
    </div>

    <!-- Baris kedua: Premium -->
    <div class="program-row center">
        <div class="program-item premium">
            <h3>Paket Premium</h3>
            <ul>
                <li>Rp 3.867.000 / 3 bulan</li>
                <li>Bonus TOEFL Preparation (2 minggu / 10 pertemuan)</li>
            </ul>
        </div>
    </div>
</section>



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

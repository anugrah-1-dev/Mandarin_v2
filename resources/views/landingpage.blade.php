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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

    @include('navbar.navbar')


    <section class="carousel" id="carousel">
        <div class="carousel-container">
            <div class="slides">
                <img src="{{ asset('asset/img/brilliant1.jpg') }}" class="slide active" alt="Slide 1">
                <img src="{{ asset('asset/img/brilliant2.jpg') }}" class="slide" alt="Slide 2">
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
            <h2 class="about-section-title">TENTANG KAMI</h2>

            <div class="about-grid">
                <div class="about-intro">
                    <h2>Brilliant English Course?</h2>
                    <p>
                        Berlokasi di jantung Kampung Inggris Pare, Brilliant English Course hadir untuk mengubah cara
                        Anda belajar bahasa Inggris. Kami menciptakan sebuah perjalanan belajar yang tidak hanya
                        efektif, tapi juga tak terlupakan, membuat Anda percaya diri dan fasih berbahasa Inggris.
                    </p>
                </div>

                <div class="features-grid">
                    <div class="feature-item">
                        <div class="icon"><i class="fas fa-comments"></i></div>
                        <h3>Lingkungan Imersif 24/7</h3>
                        <p>Dengan sistem asrama (camp) berbasis "English Area", Anda akan terbiasa berpikir dan
                            berbicara dalam bahasa Inggris setiap hari. Metode ini terbukti mempercepat kelancaran Anda
                            secara signifikan.</p>
                    </div>

                    <div class="feature-item">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Metode Belajar Praktis</h3>
                        <p>Kami fokus pada 80% praktik dan 20% teori. Kelas interaktif, simulasi dunia nyata, dan materi
                            yang relevan membuat proses belajar menjadi efektif, anti-bosan, dan menyenangkan.</p>
                    </div>

                    <div class="feature-item">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h3>Tutor Profesional & Suportif</h3>
                        <p>Tutor kami bukan hanya pengajar, tapi juga mentor yang ramah dan berpengalaman. Mereka siap
                            membimbing Anda langkah demi langkah untuk mencapai target belajar Anda.</p>
                    </div>

                    <div class="feature-item">
                        <div class="icon"><i class="fas fa-book-open-reader"></i></div>
                        <h3>Program Terstruktur & Komunitas</h3>
                        <p>Pilih program yang sesuai tujuan Anda, mulai dari Speaking, TOEFL, hingga IELTS. Bergabunglah
                            dengan komunitas pembelajar yang solid dan saling mendukung untuk sukses bersama.</p>
                    </div>
                </div>
            </div>
        </div>

    </section>
    <div class="wave-divider">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="registration-flow-section" id="alur-pendaftaran">
        <div class="container">
            <h2 class="registration-section-title">ALUR PENDAFTARAN</h2>
            <p class="registration-section-subtitle">Ikuti langkah-langkah berikut untuk mendaftar di Brilliant English
                Course:</p>

            <div class="flow-steps">
                <div class="flow-step">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Isi Formulir Pendaftaran</h3>
                        <p>Isi data diri Anda secara lengkap melalui formulir online yang tersedia di website kami.</p>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Verifikasi & Konfirmasi</h3>
                        <p>Tim kami akan menghubungi Anda untuk verifikasi dan memberikan informasi lebih lanjut.</p>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Pembayaran & Bukti Transfer</h3>
                        <p>Lakukan pembayaran sesuai instruksi, lalu unggah bukti transfer melalui halaman konfirmasi.
                        </p>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Daftar Ulang</h3>
                        <p>Melakukan daftar ulang secara langsung melalui Admin kami yang berada di  Ruang Office Brilliant English Course.</p>
                    </div>
                </div>

                <div class="flow-step">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Siap Belajar!</h3>
                        <p>Selamat! Anda resmi terdaftar dan siap mengikuti program pembelajaran di Brilliant English
                                Course.</p>
                </div>
            </div>
    </section>
    </div>
    </div>
    </div>
    </section>

    <div class="wave-divider2">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill2"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <div class="container">
        {{-- Loop untuk menampilkan semua program yang aktif --}}
        @foreach ($programs->where('status', 'aktif') as $index => $program)
    
            {{-- Logika untuk kelas 'active' dan ID dihapus agar semua tampil --}}
            <div class="program-detail @if ($index % 2 == 0) layout-left @else layout-right @endif">
    
                <div class="program-content-container">
    
                    {{-- Kartu teks --}}
                    <div class="card-info">
                        <div class="content-text content-structured">
                            <h3>{{ $program->judul }}</h3>
                            <p class="description">{{ $program->deskripsi }}</p>
    
                            <div class="benefits-container">
                                <p class="benefits-title"><strong>Keunggulan Program:</strong></p>
                                <div class="benefits-grid">
                                    @php
                                        $benefits = explode("\n", $program->keunggulan);
                                    @endphp
                                    @foreach ($benefits as $item)
                                        @if (trim($item) != '')
                                            <div class="benefit-item"><i class="fas fa-check-circle"></i>
                                                {{ trim($item) }}</div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Gambar --}}
                    <div class="content-image card-image">
                        <img src="{{ asset('uploads/programs/' . $program->gambar) }}"
                             alt="{{ $program->judul }}" onclick="openLightbox(this)">
                    </div>
                    
    
                </div>
            </div>
        @endforeach
    </div>
    
        <section class="program-section" id="program">
            <div class="container">
               
                    <div class="program-card-image-wrapper">
                <div class="text-center mb-5">
                    <h2>PROGRAM</h2>
                    <p class="lead text-muted">Temukan program yang paling sesuai dengan tujuan Anda.</p>
                </div>
                <div class="filter-buttons-wrapper">
                    <button class="filter-btn active" data-filter="offline">Program Offline</button>
                    <button class="filter-btn" data-filter="online">Program Online</button>
                </div>

                {{-- INI BAGIAN PENTING: Container untuk Grid --}}
                <div class="program-grid">

                    {{-- Loop untuk Program OFFLINE --}}
                    @forelse ($offlinePrograms as $program)
                        <div class="program-item" data-filter="offline">
                            <div class="program-card">
                                <div class="program-card-image-wrapper">
                          
              <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img" alt="{{ $program->nama }}">
                                    @if ($program->is_active)

                                    @endif
                                </div>
                                <div class="program-card-body">
                                    <h5 class="program-card-title">{{ $program->nama }}</h5>
                                    <p class="program-card-info">
                                        <i class="fas fa-calendar-alt"></i>
                                        {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                    </p>
                                    <p class="program-card-price">Rp {{ number_format($program->harga, 0, ',', '.') }}</p>
                                    <a href="{{ route('public.program.offline.show', $program->slug) }}" class="btn btn-success">Lihat Detail</a>

                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    {{-- Loop untuk Program ONLINE --}}
                    @forelse ($onlinePrograms as $program)
                        <div class="program-item" data-filter="online">
                             <div class="program-card">
                                <div class="program-card-image-wrapper">
                                    <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img" alt="{{ $program->nama }}">
                                    @if ($program->is_active)

                                    @endif
                                </div>
                                <div class="program-card-body">
                                    <h5 class="program-card-title">{{ $program->nama }}</h5>
                                    <p class="program-card-info">
                                        <i class="fas fa-tag"></i>
                                        Kategori: {{ $program->kategori ?? '-' }}
                                    </p>
                                    <p class="program-card-price">Rp {{ number_format($program->harga, 0, ',', '.') }}</p>
                                    <a href="{{ route('public.program.online.show', $program->slug) }}" class="btn btn-success">Lihat Detail</a>

                                </div>
                            </div>
                        </div>
                    @empty
                    @endforelse

                    {{-- Pesan jika tidak ada program yang cocok --}}
                    <div id="no-program-message" class="no-program-notice" style="display: none;">
                        <p>Tidak ada program yang tersedia untuk kategori ini.</p>
                    </div>
                </div>
    </section>

    <div class="wave-divider4">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill4"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>


            <script>
 document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const programItems = document.querySelectorAll('.program-item');
    const noProgramMessage = document.getElementById('no-program-message');

    function filterItems(filterValue) {
        let visibleCount = 0;
        programItems.forEach(item => {
            if (item.dataset.filter === filterValue) {
                item.classList.remove('hidden');
                visibleCount++;
            } else {
                item.classList.add('hidden');
            }
        });

        if (visibleCount === 0) {
            noProgramMessage.style.display = 'block';
        } else {
            noProgramMessage.style.display = 'none';
        }
    }

    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            const filterValue = this.dataset.filter;
            filterItems(filterValue);
        });
    });

    const initialActiveButton = document.querySelector('.filter-btn.active');
    if (initialActiveButton) {
        filterItems(initialActiveButton.dataset.filter);
    } else {
        // Jika tidak ada yang aktif, tampilkan yang pertama secara default
        if(filterButtons.length > 0){
             filterButtons[0].classList.add('active');
             filterItems(filterButtons[0].dataset.filter);
        }
    }
});
</script>

           

    <link rel="stylesheet" href="{{ asset('css/program.css') }}">

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('.program-tabs .tab-button');
            const contents = document.querySelectorAll('.program-detail');

            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    const targetId = tab.dataset.tab;

                    tabs.forEach(t => t.classList.remove('active'));
                    tab.classList.add('active');

                    contents.forEach(content => content.classList.remove('active'));
                    const targetContent = document.getElementById(targetId);
                    if (targetContent) {
                        targetContent.classList.add('active');
                    }
                });
            });
        });
    </script>

<section class="camp-section"id="camp">
    <div class="container">
       
            <div class="program-card-image-wrapper">
        <div class="text-center mb-5">
            <h2 class="section-title-camp">CAMP BIEPLUS</h2>
            <p class="section-subtitle-camp">CAMP BIEPLUS menawarkan kenyamanan, fasilitas lengkap, dan lokasi strategis untuk mendukung pengalaman belajar terbaik Anda di Kampung Inggris Pare.</p>
        </div>

        <div class="camp-grid">
            {{-- Loop data dari controller --}}
            @forelse ($camps as $camp)
            <div class="camp-card">
                <div class="camp-card-image">
                    {{-- Kita gunakan thumbnail utama. Untuk galeri kecil di dalam kartu akan memerlukan struktur database yang berbeda --}}
                    <img src="{{ asset('upload/camp/' . $camp->thumbnail) }}" alt="{{ $camp->nama }}">
                </div>
                <div class="camp-card-body">
                    <h3 class="camp-card-title">{{ $camp->nama }}</h3>
                    <p class="camp-card-description">
                        {{-- Asumsi Anda memiliki kolom 'deskripsi' di tabel camp Anda --}}
                        {{ $camp->deskripsi ?? 'Pilihan terbaik dengan fasilitas modern dan kenyamanan optimal untuk pengalaman belajar yang maksimal.' }}
                    </p>
                    <div class="promo-banner">
                        <i class="fas fa-star"></i> Special Promo Available <i class="fas fa-fire"></i>
                    </div>
                    <a href="{{ route('camps.show', $camp->slug) }}" class="btn-details">Lihat Selengkapnya →</a>                </div>
            </div>
                @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada informasi camp yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>

            <div class="wave-divider5">
                <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path class="shape-fill5"
                        d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>

    <section id="galeri" class="gallery">
        <h2 class="section-title">GALLERY</h2>

    <div class="gallery-slider-wrapper">
        <button class="gallery-nav left" onclick="slideGalleryGrid(-1)">
    <i class="fas fa-chevron-left"></i>
</button>

        <div class="gallery-scroll-outer">
            <div class="gallery-scroll-inner" id="gallerySlider">
                @php $index = 0; @endphp
                @foreach ($galleries as $gallery)
                    @if ($gallery->images->isNotEmpty())
                        <div class="gallery-frame text-center" data-index="{{ $index }}">
    <img src="{{ asset('storage/' . $gallery->images->first()->image_path) }}"
        alt="{{ $gallery->title }}" class="gallery-thumbnail"
        onclick="openGalleryModal({{ $gallery->id }})">
    
    <div class="gallery-caption">
        <h5>{{ $gallery->title }}</h5>
        <p>{{ Str::limit($gallery->deskripsi ?? 'Galeri kegiatan Brilliant', 50) }}</p>
    </div>
</div>


                        <!-- Modal -->
                        <div id="modal-{{ $gallery->id }}" class="gallery-modal">
                            <div class="modal-content">
                                <span class="close-btn" onclick="closeGalleryModal({{ $gallery->id }})">&times;</span>
                                <h3>{{ $gallery->title }}</h3>
                                <div class="modal-slider-wrapper">
                                    <button class="nav-btn left" onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                    <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                        @foreach ($gallery->images as $image)
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Image">
                                        @endforeach
                                    </div>
                                    <button class="nav-btn right" onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
                                </div>
                            </div>
                        </div>
                        @php $index++; @endphp
                    @endif
                @endforeach
            </div>
        </div>

        <button class="gallery-nav right" onclick="slideGalleryGrid(1)">
    <i class="fas fa-chevron-right"></i>
</button>
    </div>
</section>

 

    <script>
        function openGalleryModal(id) {
            document.getElementById('modal-' + id).classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeGalleryModal(id) {
            document.getElementById('modal-' + id).classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        // Geser slider ke kiri atau kanan
        function slideGallery(id, direction) {
            const slider = document.getElementById('slider-' + id);
            const scrollAmount = 300; // px
            slider.scrollBy({
                left: scrollAmount * direction,
                behavior: 'smooth'
            });
        }
    </script>



    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <span class="lightbox-close" onclick="closeLightbox()">x</span>
        <img class="lightbox-content" id="lightboxImg">
    </div>

 <div class="wave-divider6">
                <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
                    <path class="shape-fill6"
                        d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>


    <section class="contact-section"
        style="background-color: #F7F7F7FF; padding: 40px 0; display: flex; flex-wrap: wrap; gap: 32px; justify-content: center;">
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
            <p style="color: #000;"><strong>Alamat:</strong><br>Jl. Flamboyan No.48, Mulyoasri, Tulungrejo, Kec. Pare,
                Kabupaten Kediri, Jawa Timur 64212</p>
            <p><strong>Email:</strong><br>
                <a href="mailto:info@kampunginggris.com"
                    class="text-blue-600 hover:underline">info@kampunginggris.com</a>
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

   <div class="wa-sticky-wrapper">
    <div class="wa-circle-row">
        <a href="https://wa.me/6281234567890" class="wa-circle tooltip" target="_blank">
            <i class="fab fa-whatsapp"></i>
            <span class="tooltip-text">Contact Person 1</span>
        </a>
        <a href="https://wa.me/6289876543210" class="wa-circle tooltip" target="_blank">
            <i class="fab fa-whatsapp"></i>
            <span class="tooltip-text">Contact Person 2</span>
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
    </script>
</body>

</html>

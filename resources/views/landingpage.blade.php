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
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

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
                <h1 data-aos="fade-left" data-aos-delay="200">BRILLIANT ENGLISH COURSE</h1>

                <p data-aos="fade-right" data-aos-delay="200">
                    Tingkatkan kemampuan Bahasa Inggris Anda dan rasakan pengalaman belajar yang berkualitas di
                    Brilliant English Course, tempat di mana potensi Anda menjadi lebih gemilang!
                </p>

                <a href="#program" class="cta-button" data-aos="fade-up" data-aos-delay="200">
                    DAFTAR SEKARANG
                </a>

            </div>
            <button class="nav prev">&#10094;</button>
            <button class="nav next">&#10095;</button>
        </div>
    </section>

    {{-- ✅ Section "Tentang Kami" dengan animasi --}}
    <section class="about-us-section" id="tentang" data-aos="fade-up">
        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <h2 class="about-section-title" data-aos="fade-up">TENTANG KAMI</h2>

            <div class="about-grid">
                <div class="about-intro" data-aos="fade-left" data-aos-delay="200">
                    <h2>Brilliant English Course?</h2>
                    <p>
                        Berlokasi di jantung Kampung Inggris Pare, Brilliant English Course hadir untuk mengubah cara
                        Anda belajar bahasa Inggris. Kami menciptakan sebuah perjalanan belajar yang tidak hanya
                        efektif, tapi juga tak terlupakan, membuat Anda percaya diri dan fasih berbahasa Inggris.
                    </p>
                </div>

                <div class="features-grid" data-aos="fade-up" data-aos-delay="300">
                    <div class="feature-item" data-aos="fade-up" data-aos-delay="400">
                        <div class="icon"><i class="fas fa-comments"></i></div>
                        <h3>Lingkungan Imersif 24/7</h3>
                        <p>Dengan sistem asrama (camp) berbasis "English Area", Anda akan terbiasa berpikir dan
                            berbicara dalam bahasa Inggris setiap hari. Metode ini terbukti mempercepat kelancaran Anda
                            secara signifikan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="500">
                        <div class="icon"><i class="fas fa-lightbulb"></i></div>
                        <h3>Metode Belajar Praktis</h3>
                        <p>Kami fokus pada 80% praktik dan 20% teori. Kelas interaktif, simulasi dunia nyata, dan materi
                            yang relevan membuat proses belajar menjadi efektif, anti-bosan, dan menyenangkan.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="600">
                        <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <h3>Tutor Profesional & Suportif</h3>
                        <p>Tutor kami bukan hanya pengajar, tapi juga mentor yang ramah dan berpengalaman. Mereka siap
                            membimbing Anda langkah demi langkah untuk mencapai target belajar Anda.</p>
                    </div>

                    <div class="feature-item" data-aos="fade-up" data-aos-delay="700">
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
                {{-- Setiap langkah diberi animasi fade-up dengan delay yang meningkat --}}
                <div class="flow-step" data-aos="fade-up" data-aos-delay="100">
                    <div class="step-number">1</div>
                    <div class="step-content">
                        <h3>Isi Formulir Pendaftaran</h3>
                        <p>Isi data diri Anda secara lengkap melalui formulir online yang tersedia di website kami.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="200">
                    <div class="step-number">2</div>
                    <div class="step-content">
                        <h3>Verifikasi & Konfirmasi</h3>
                        <p>Tim kami akan menghubungi Anda untuk verifikasi dan memberikan informasi lebih lanjut.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="300">
                    <div class="step-number">3</div>
                    <div class="step-content">
                        <h3>Pembayaran & Bukti Transfer</h3>
                        <p>Lakukan pembayaran sesuai instruksi, lalu unggah bukti transfer melalui halaman konfirmasi.
                        </p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="400">
                    <div class="step-number">4</div>
                    <div class="step-content">
                        <h3>Daftar Ulang</h3>
                        <p>Melakukan daftar ulang secara langsung melalui Admin kami yang berada di Ruang Office
                            Brilliant English Course.</p>
                    </div>
                </div>

                <div class="flow-step" data-aos="fade-up" data-aos-delay="500">
                    <div class="step-number">5</div>
                    <div class="step-content">
                        <h3>Siap Belajar!</h3>
                        <p>Selamat! Anda resmi terdaftar dan siap mengikuti program pembelajaran di Brilliant English
                            Course.</p>
                    </div>
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
        @foreach ($programs->where('status', 'aktif') as $index => $program)
            {{-- Container utama diberi animasi 'fade-up' --}}
            <div class="program-detail @if ($index % 2 == 0) layout-left @else layout-right @endif"
                data-aos="fade-up">

                <div class="program-content-container">

                    {{-- Kartu teks diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="card-info" data-aos="{{ $index % 2 == 0 ? 'fade-right' : 'fade-left' }}"
                        data-aos-delay="200">
                        <div class="content-text content-structured">
                            <h3
                                style="font-weight: bold; text-align: center; font-family: 'Poppins', 'Times New Roman', serif;">
                                {{ $program->judul }}
                            </h3>
                            <p class="description" style="text-align: justify;">
                                {!! nl2br(e($program->deskripsi)) !!}
                            </p>
                            <div class="benefits-container">
                                <p class="benefits-title"><strong>Keunggulan Program:</strong></p>
                                <div class="benefits-grid">
                                    @php
                                        $benefits = explode("\n", $program->keunggulan);
                                    @endphp
                                    @foreach ($benefits as $item)
                                        @if (trim($item) != '')
                                            <div class="benefit-item">
                                                <i class="fas fa-check-circle"></i> {{ trim($item) }}
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar diberi animasi berdasarkan posisi genap/ganjil --}}
                    <div class="content-image card-image"
                        data-aos="{{ $index % 2 == 0 ? 'fade-left' : 'fade-right' }}" data-aos-delay="200">
                        <img src="{{ asset('uploads/programs/' . $program->gambar) }}" alt="{{ $program->judul }}"
                            onclick="openLightbox(this)">
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>PILIHAN PROGRAM</h2>
                <p class="lead text-muted">Temukan program yang paling sesuai dengan tujuan Anda.</p>
            </div>

            {{-- Tombol Filter diberi animasi --}}
            <div class="filter-buttons-wrapper" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="offline">Program Offline</button>
                <button class="filter-btn" data-filter="online">Program Online</button>
            </div>

            {{-- Container Grid Utama --}}
            <div class="program-grid">

                {{-- Loop untuk Program OFFLINE --}}
                @forelse ($offlinePrograms as $index => $program)
                    {{-- Setiap kartu diberi animasi fade-up dengan delay yang berbeda --}}
                    <div class="program-item" data-filter="offline" data-aos="fade-up"
                        data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="program-card-image-wrapper">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img"
                                    alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                </p>
                                <p class="card-text program-card-price mb-3">Rp
                                    {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.offline.show', $program->slug) }}"
                                    class="btn btn-success mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

                {{-- Loop untuk Program ONLINE --}}
                @forelse ($onlinePrograms as $index => $program)
                    <div class="program-item" data-filter="online" data-aos="fade-up"
                        data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}" class="program-card-img"
                                    alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    Kategori: {{ $program->kategori ?? '-' }}
                                </p>
                                <p class="card-text program-card-price mb-3">Rp
                                    {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.online.show', $program->slug) }}"
                                    class="btn btn-success mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <div id="no-program-message" class="text-center text-muted mt-5" style="display: none;">
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
                if (filterButtons.length > 0) {
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
    <div class="wave-divider7">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill7"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
    <section class="camp-section" id="camp">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2 class="section-title-camp">CAMP BIEPLUS</h2>
                <p class="section-subtitle-camp">CAMP BIEPLUS menawarkan kenyamanan, fasilitas lengkap, dan lokasi
                    strategis untuk mendukung pengalaman belajar terbaik Anda di Kampung Inggris Pare.</p>
            </div>

            <div class="camp-grid">
                {{-- Loop data dari controller --}}
                @forelse ($camps as $index => $camp)
                    {{-- Setiap kartu diberi animasi fade-up dengan delay yang meningkat --}}
                    <div class="camp-card" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="camp-card-image">
                            <img src="{{ asset('upload/camp/' . $camp->thumbnail) }}" alt="{{ $camp->nama }}">
                        </div>
                        <div class="camp-card-body">
                            <h3 class="camp-card-title text-center fw-bold text-decoration-underline fs-4" style="color: #0d47a1;">
                                {{ $camp->nama }}
                            </h3>
                            <div class="camp-card-description">

                                {{-- ============================== --}}
                                {{-- Deskripsi Berdasarkan Urutan Index --}}
                                {{-- ============================== --}}
                                @php
                                    $posisi = $loop->index % 3; // 0,1,2 berulang
                                @endphp
                            
                                @switch($posisi)
                                    @case(0)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (VVIP)</strong> adalah pilihan premium kami yang dirancang khusus untuk memberikan privasi dan kenyamanan maksimal bagi peserta. Cocok bagi Anda yang ingin fokus belajar dengan fasilitas terbaik.
                                        </p>
                                        @break
                            
                                    @case(1)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (VIP)</strong> menawarkan perpaduan ideal antara fasilitas modern dan kenyamanan. Pilihan ini cocok bagi peserta yang ingin belajar secara intensif dengan suasana nyaman.
                                        </p>
                                        @break
                            
                                    @case(2)
                                        <p style="text-align: justify;">
                                            <strong>BIE+ Camp (Barack)</strong> adalah solusi ekonomis bagi peserta yang mengutamakan kebersamaan dan efisiensi. Fasilitas memadai untuk menunjang proses belajar di Kampung Inggris.
                                        </p>
                                        @break
                                @endswitch
                            
                                {{-- ============================== --}}
                                {{-- Fasilitas Dinamis --}}
                                {{-- ============================== --}}
                                <strong>Fasilitas:</strong>
                                <ul>
                                    @foreach(explode(',', $camp->fasilitas) as $fasilitas)
                                        <li>{{ trim($fasilitas) }}</li>
                                    @endforeach
                                </ul>
                            
                            </div>
                            
                            <div class="promo-banner">
                                <i class="fas fa-star"></i> Special Promo Available <i class="fas fa-fire"></i>
                            </div>
                            <a href="{{ route('camps.show', $camp->slug) }}" class="btn-details">Lihat
                                Selengkapnya →</a>
                        </div>
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
        <div class="container" data-aos="fade-up">
            <h2 class="section-title">GALLERY</h2>
            <p class="section-subtitle text-center mb-4">
                Dokumentasi kegiatan dan momen-momen seru bersama Brilliant English Course
            </p>

            <div class="gallery-slider-wrapper">
                <button class="gallery-nav left" onclick="slideGalleryGrid(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>

                <div class="gallery-scroll-outer">
                    <div class="gallery-scroll-inner" id="gallerySlider">
                        @php $index = 0; @endphp
                        @foreach ($galleries as $gallery)
                            @if ($gallery->images->isNotEmpty())
                                {{-- Setiap frame galeri diberi animasi fade-up dengan delay --}}
                                <div class="gallery-frame text-center" data-index="{{ $index }}"
                                    data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}">
                                    <img src="{{ asset('storage/' . $gallery->images->first()->image_path) }}"
                                        alt="{{ $gallery->title }}" class="gallery-thumbnail"
                                        onclick="openGalleryModal({{ $gallery->id }})">

                                    <div class="gallery-caption">
                                        <h5>{{ $gallery->title }}</h5>
                                        <p>{{ Str::limit($gallery->deskripsi ?? 'Galeri kegiatan Brilliant', 50) }}</p>
                                    </div>
                                </div>

                                <div id="modal-{{ $gallery->id }}" class="gallery-modal">
                                    <div class="modal-content">
                                        <span class="close-btn"
                                            onclick="closeGalleryModal({{ $gallery->id }})">&times;</span>
                                        <h3>{{ $gallery->title }}</h3>
                                        <div class="modal-slider-wrapper">
                                            <button class="nav-btn left"
                                                onclick="slideGallery({{ $gallery->id }}, -1)">&#8592;</button>
                                            <div class="modal-slider" id="slider-{{ $gallery->id }}">
                                                @foreach ($gallery->images as $image)
                                                    <img src="{{ asset('storage/' . $image->image_path) }}"
                                                        alt="Image">
                                                @endforeach
                                            </div>
                                            <button class="nav-btn right"
                                                onclick="slideGallery({{ $gallery->id }}, 1)">&#8594;</button>
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

    <link rel="stylesheet" href="{{ asset('css/sosmed.css') }}">

    <section id="sosmed" class="sosmed-section">
        <div class="container">
            <h2 class="section-title">Sosial Media Kami</h2>
            @if (!$hasSosmed)
                <p class="text-center">Belum ada data yang ditambahkan. Stay tuned!</p>
            @else
                @foreach ($groupedSosmed as $platform => $items)
                    @if (count($items) > 0)
                        <div class="mb-5">
                            <h4 class="section-subtitle fw-semibold mb-4">{{ $platform }}</h4>
                            <div class="sosmed-grid">
                                @foreach ($items as $item)
                                    <div class="sosmed-card" data-platform="{{ strtolower($platform) }}">
                                        <div class="sosmed-card-image">
                                            @if (strtolower($platform) === 'youtube')
                                                <div class="sosmed-card-video">
                                                    <iframe width="100%" height="200"
                                                        src="https://www.youtube.com/embed/{{ getYoutubeVideoId($item->url) }}"
                                                        title="YouTube video player" frameborder="0"
                                                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                        allowfullscreen>
                                                    </iframe>
                                                </div>
                                            @elseif (strtolower($platform) === 'instagram')
                                                <a href="{{ $item->url }}" target="_blank"
                                                    rel="noopener noreferrer">
                                                    <img src="{{ asset('storage/' . $item->image_path) }}"
                                                        alt="Instagram Image">
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
    </section>

    <link rel="stylesheet" href="{{ asset('css/kontak.css') }}">

    <div class="wave-dividerkontak">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fillkontak"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section id="kontak" class="kontak-section">
        <div class="container">
            <h2 class="section-title">Kontak Kami</h2>
            <p class="kontak-subtitle">
                Ingin terhubung dengan kami? Silakan hubungi lewat email atau sosial media berikut.
            </p>

            <div class="kontak-info">
                <p><strong>Email:</strong> <a href="mailto:example@email.com">example@email.com</a></p>
                <p><strong>Instagram:</strong> <a href="https://instagram.com" target="_blank">@namakamu</a></p>
                <p><strong>YouTube:</strong> <a href="https://youtube.com" target="_blank">Channel Kami</a></p>
            </div>

            <div class="kontak-maps">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.299223137717!2d112.1899974!3d-7.758055899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db5d1b27adb%3A0xa8f77ed278eedc6!2sBrilliant%20English%20Course%20Kampung%20Inggris%20Pare!5e0!3m2!1sen!2sid!4v1753597882357!5m2!1sen!2sid"
                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
            </div>
        </div>
    </section>



    <footer>
        © 2025 Brilliant English Course. Hak Cipta Dilindungi Oleh Undang-Undang
    </footer>


    @include('partials.whatsapp-floating')

</body>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<script>
    AOS.init({
        duration: 800, // Durasi animasi
        once: true, // Animasi hanya berjalan sekali
    });
</script>

</html>

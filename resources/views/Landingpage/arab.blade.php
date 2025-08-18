<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa Arab</title>
    <link rel="stylesheet" href="{{ asset('css/arablandingpage.css') }}">
</head>

<body>
    @include('navbar.navbar')
    <!-- Hero Carousel -->
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">
                    <img src={{ asset('asset/img/brilliant1.jpg') }} alt="Belajar Bahasa Arab 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant2.jpg') }} alt="Belajar Bahasa Arab 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant3.jpg') }} alt="Belajar Bahasa Arab 3">
                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="hero-text">
            <h1>BRILLIANT ENGLISH COURSE</h1>
            <h2>(Kursus Bahasa Arab)</h2>
            <p>Kuasai bahasa Arab dengan metode interaktif dan pengajar berpengalaman.</p>

        </div>
    </section>

    <!-- PROGRAM SECTION WITH FILTERING -->
    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>ARAB PROGRAM CHOICES</h2>
                <p class="lead text-muted">Temukan program yang sesuai dengan tujuan Anda.</p>
            </div>

            <div class="filter-buttons-wrapper text-center mb-4" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="offline">Offline Programs</button>
                <button class="filter-btn" data-filter="online">Online Programs</button>
            </div>

            <div class="program-grid">
                <!-- Offline Programs -->
                @forelse ($offlinePrograms as $index => $program)
                    <div class="program-item offline" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}"
                        style="display: none;">
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
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('M d, Y') }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.offline.show', $program->slug) }}"
                                    class="btn btn-primary mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-item offline" style="display: none;">
                        <p class="text-muted">Belum ada program offline tersedia</p>
                    </div>
                @endforelse

                <!-- Online Programs -->
                @forelse ($onlinePrograms as $index => $program)
                    <div class="program-item online" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}"
                        style="display: none;">
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
                                    <i class="fas fa-tag me-1"></i>
                                    Kategori: {{ $program->kategori ?? '-' }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.online.show', $program->slug) }}"
                                    class="btn btn-danger mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-item online" style="display: none;">
                        <p class="text-muted">Belum ada program online tersedia</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- JS filter program sama seperti versi Inggris --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const programItems = document.querySelectorAll('.program-item');

            // Show offline by default
            document.querySelector('.filter-btn[data-filter="offline"]').classList.add('active');
            document.querySelectorAll('.program-item.offline').forEach(item => {
                item.style.display = 'block';
            });

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const filterValue = this.getAttribute('data-filter');
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    programItems.forEach(item => {
                        if (item.classList.contains(filterValue)) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
        });
    </script>

    <script>
        const slides = document.querySelectorAll(".slide");
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");
        let current = 0;

        function showSlide(index) {
            slides.forEach((s, i) => s.classList.toggle("active", i === index));
        }

        nextBtn.addEventListener("click", () => {
            current = (current + 1) % slides.length;
            showSlide(current);
        });

        prevBtn.addEventListener("click", () => {
            current = (current - 1 + slides.length) % slides.length;
            showSlide(current);
        });

        // Auto-slide
        setInterval(() => {
            current = (current + 1) % slides.length;
            showSlide(current);
        }, 5000);
    </script>


    <div class="wave-divider">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
    <!-- Alur Pendaftaran -->
    <section class="alur" id="alur">
        <div class="container">
            <h2>Alur Pendaftaran</h2>
            <p>Ikuti langkah-langkah berikut untuk mendaftar di <strong>Brilliant English Course</strong>:</p>

            <div class="alur-timeline">
                <div class="step">
                    <div class="circle">1</div>
                    <h3>Isi Formulir Pendaftaran</h3>
                    <p>Isi data diri Anda secara lengkap melalui formulir online yang tersedia di website kami.</p>
                </div>
                <div class="step">
                    <div class="circle">2</div>
                    <h3>Verifikasi & Konfirmasi</h3>
                    <p>Tim kami akan menghubungi Anda untuk verifikasi dan memberikan informasi lebih lanjut.</p>
                </div>
                <div class="step">
                    <div class="circle">3</div>
                    <h3>Pembayaran & Bukti Transfer</h3>
                    <p>Lakukan pembayaran sesuai instruksi, lalu unggah bukti transfer melalui halaman konfirmasi.</p>
                </div>
                <div class="step">
                    <div class="circle">4</div>
                    <h3>Daftar Ulang</h3>
                    <p>Melakukan daftar ulang secara langsung melalui Admin kami yang berada di Ruang Office Brilliant
                        English Course.</p>
                </div>
                <div class="step">
                    <div class="circle">5</div>
                    <h3>Siap Belajar!</h3>
                    <p>Selamat! Anda resmi terdaftar dan siap mengikuti program pembelajaran di Brilliant English
                        Course.</p>
                </div>
            </div>

        </div>
        </div>
    </section>

    </section>
    <div class="wave-divider2">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill2"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    <section class="about" id="tentang">
        <div class="container">
            <h2>Informasi </h2>
            <p><strong>Brilliant English Course</strong> menghadirkan program khusus <span class="highlight">Bahasa
                    Arab</span>
                yang dirancang untuk semua kalangan. Dengan metode pembelajaran yang interaktif, pengajar berpengalaman,
                serta suasana belajar yang menyenangkan, kami berkomitmen membantu Anda menguasai bahasa Arab dengan
                mudah dan efektif.</p>

            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor,
                dignissim sit amet, adipiscing nec, ultricies sed, dolor. Cras elementum ultrices diam.</p>

            <div class="about-grid">
                <div class="about-card">
                    <h3>Metode Modern</h3>
                    <p>Pembelajaran dengan pendekatan interaktif dan sesuai kebutuhan peserta.</p>
                </div>
                <div class="about-card">
                    <h3>Pengajar Berpengalaman</h3>
                    <p>Instruktur yang fasih dan memiliki pengalaman mengajar bertahun-tahun.</p>
                </div>
                <div class="about-card">
                    <h3>Lingkungan Nyaman</h3>
                    <p>Belajar dengan suasana kondusif, mendukung perkembangan bahasa secara alami.</p>
                </div>
            </div>
        </div>

    </section>

    </section>
    <div class="wave-divider3">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill3"
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
                <p><strong>Instagram:</strong> <a
                        href="https://www.instagram.com/biecast_brilliankampunginggris?igsh=bzdhMGVyemIxZGQ="
                        target="_blank">@biecast_brilliankampunginggris</a></p>
                <p><strong>YouTube:</strong> <a
                        href="https://youtube.com/@bieplusbrilliantenglishcourse?si=VxZw3YfiD4t5LciM"
                        target="_blank">BIECAST Brilliant English Course</a></p>
            </div>

            <div class="kontak-maps">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3953.299223137717!2d112.1899974!3d-7.758055899999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e785db5d1b27adb%3A0xa8f77ed278eedc6!2sBrilliant%20English%20Course%20Kampung%20Inggris%20Pare!5e0!3m2!1sen!2sid!4v1753597882357!5m2!1sen!2sid"
                    width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy">
                </iframe>
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
    <footer>
        © 2025 Brilliant English Course. Hak Cipta Dilindungi Oleh Undang-Undang
    </footer>

</body>

</html>
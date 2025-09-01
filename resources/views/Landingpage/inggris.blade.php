<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa Inggris</title>
    <link rel="stylesheet" href="{{ asset('css/inggrislandingpage.css') }}">
    <!-- Bootstrap 5.3 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5.3 JS Bundle (termasuk Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body>
    @include('navbar.nav')


    <!-- Hero Carousel -->
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">
                    <img src="{{ asset('asset/img/brilliant1.jpg') }}" alt="Belajar Bahasa Arab 1">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliant2.jpg') }}" alt="Belajar Bahasa Arab 2">
                </div>
                <div class="slide">
                    <img src="{{ asset('asset/img/brilliant3.jpg') }}" alt="Belajar Bahasa Arab 3">
                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="hero-text">
            <h1>BRILLIANT ENGLISH COURSE</h1>
            <h2>(Kursus Bahasa Inggris)</h2>
            <p>Kuasai bahasa Inggris dengan metode interaktif dan pengajar berpengalaman.</p>
        </div>
    </section>

    <!-- PROGRAM SECTION WITH FILTERING -->
    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>ENGLISH PROGRAM CHOICES</h2>
                <p class="lead text-muted">Find the program that best suits your goals.</p>
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
                                    <span class="badge bg-success program-badge">Available</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                {{-- <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('M d, Y') }}
                                </p> --}}

                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                {{-- Garis pemisah sebelum fitur --}}

                                <hr class="my-3 mx-auto hr-half">

                                <h5 class="text-center mb-4">Fasilitas Program</h5>

                                @php
                                    $features = $program->features_program;

                                    if (is_string($features)) {
                                        $decoded = json_decode($features, true);
                                        $features =
                                            json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                                ? $decoded
                                                : preg_split('/\r\n|\r|\n/', $features);
                                    }
                                @endphp

                                @if (!empty($features) && is_array($features))
                                    <div class="text-center">
                                        <ul class="list-unstyled d-inline-block text-start mb-0">
                                            @foreach ($features as $fitur)
                                                <li class="d-flex align-items-center mb-2">
                                                    {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                                    <span class="ms-2">{{ trim($fitur) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="text-center text-muted mb-0">
                                        <em>Tidak ada fasilitas tersedia.</em>
                                    </p>
                                @endif
                                <br>




                                <a href="{{ route('public.program.offline.show', $program->slug) }}"
                                    class="btn btn-primary mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="program-item offline" style="display: none;">
                        <p class="text-muted">No offline programs available</p>
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
                                    <span class="badge bg-success program-badge">Available</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    Category: {{ $program->kategori ?? '-' }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>


                                <hr class="my-3 mx-auto hr-half">

                                <h5 class="text-center mb-4">Fasilitas Program</h5>

                                @php
                                    $features = $program->features_program;

                                    if (is_string($features)) {
                                        $decoded = json_decode($features, true);
                                        $features =
                                            json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                                ? $decoded
                                                : preg_split('/\r\n|\r|\n/', $features);
                                    }
                                @endphp

                                @if (!empty($features) && is_array($features))
                                    <div class="text-center">
                                        <ul class="list-unstyled d-inline-block text-start mb-0">
                                            @foreach ($features as $fitur)
                                                <li class="d-flex align-items-center mb-2">
                                                    {!! \App\Helpers\FeatureHelper::getFeatureIcon($fitur) !!}
                                                    <span class="ms-2">{{ trim($fitur) }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p class="text-center text-muted mb-0">
                                        <em>Tidak ada fasilitas tersedia.</em>
                                    </p>
                                @endif
                                <br>
                                <a href="{{ route('public.program.online.show', $program->slug) }}"
                                    class="btn btn-danger mt-auto">View Details</a>
                            </div>
                        </div>
                    </div>

                @empty
                    <div class="program-item online" style="display: none;">
                        <p class="text-muted">No online programs available</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- About Section --}}
    <section class="about py-5" id="about">
        <div class="container text-center" data-aos="fade-up">
            <h2 class="mb-4">Why Choose Us?</h2>
            <p class="mb-5">
                At <strong>Brilliant English Course</strong>, we believe that learning Mandarin is an exciting
                adventure. We combine the <span class="highlight">best teaching methods</span> with an interactive
                approach to create an effective and unforgettable learning experience.
            </p>
            <div class="about-grid">
                <div class="about-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper"><i class="fas fa-rocket"></i></div>
                    <h3>Structured Curriculum</h3>
                    <p>Our lessons are designed according to international standards (HSK) to ensure measurable
                        progress.</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper"><i class="fas fa-user-tie"></i></div>
                    <h3>Professional Instructors</h3>
                    <p>Learn from experienced Laoshi, both certified native speakers and local professionals.</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
                    <h3>Active Community</h3>
                    <p>Join a supportive community to practice conversations and explore culture together.</p>
                </div>
            </div>
        </div>
    </section>


    <section class="alur-container">
        <!-- Wave Divider at Top -->
        <div class="wave-line">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 20" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="waveGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                        <stop offset="0%" style="stop-color:#0b2470; stop-opacity:1" />
                        <stop offset="100%" style="stop-color:#1d3fa3; stop-opacity:1" />
                    </linearGradient>
                </defs>

                <!-- Wave Path -->
                <path class="wave-path" d="M0 10 Q 15 0 30 10 T 60 10 T 90 10 T 120 10 V 20 H 0 Z"
                    fill="url(#waveGradient)" />
            </svg>
        </div>



        <!-- Main Content -->
        <div class="alur py-5" id="alur">
            <div class="container text-center" data-aos="fade-up">
                <h2 class="mb-4">Alur Pendaftaran</h2>
                <p class="mb-5">Ikuti langkah-langkah berikut untuk mendaftar di Brilliant English Course.</p>
                <div class="alur-timeline">
                    <div class="step" data-aos="fade-up" data-aos-delay="50">
                        <div class="circle">1</div>
                        <h3>Isi Formulir</h3>
                        <p>Lengkapi data diri Anda melalui formulir online.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="150">
                        <div class="circle">2</div>
                        <h3>Konfirmasi Tim</h3>
                        <p>Tim kami akan menghubungi Anda untuk verifikasi data.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="250">
                        <div class="circle">3</div>
                        <h3>Pembayaran</h3>
                        <p>Lakukan pembayaran sesuai instruksi yang diberikan.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="350">
                        <div class="circle">4</div>
                        <h3>Daftar Ulang</h3>
                        <p>Kunjungi admin kami di kantor untuk daftar ulang.</p>
                    </div>
                    <div class="step" data-aos="fade-up" data-aos-delay="450">
                        <div class="circle">5</div>
                        <h3>Selamat Belajar!</h3>
                        <p>Anda resmi menjadi bagian dari Brilliant English Course.</p>
                    </div>
                </div>
            </div>

    </section>


    <!-- Footer -->
    <footer class="footer text-center">
        <p>© 2025 Brilliant English Course | Programming Bahasa Inggris</p>
    </footer>


    <style>




    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const programItems = document.querySelectorAll('.program-item');

            // Show offline programs by default
            document.querySelector('.filter-btn[data-filter="offline"]').classList.add('active');
            document.querySelectorAll('.program-item.offline').forEach(item => {
                item.style.display = 'block';
            });

            // Filter functionality
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filterValue = this.getAttribute('data-filter');

                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    // Show/hide programs
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

        // Function untuk mendeteksi elemen yang terlihat di viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function untuk menangani scroll animation
        function handleScrollAnimation() {
            const programSection = document.querySelector('.program-section');

            if (programSection && isInViewport(programSection)) {
                programSection.classList.add('visible');
                // Hapus event listener setelah animasi dipicu sekali
                window.removeEventListener('scroll', handleScrollAnimation);
            }
        }

        // Event listener untuk scroll dan load
        window.addEventListener('scroll', handleScrollAnimation);
        window.addEventListener('load', handleScrollAnimation);

        // Function untuk mendeteksi elemen yang terlihat di viewport
        function isInViewport(element) {
            const rect = element.getBoundingClientRect();
            return (
                rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
                rect.bottom >= 0
            );
        }

        // Function untuk menangani scroll animation timeline
        function handleTimelineAnimation() {
            const alurSection = document.querySelector('.alur');

            if (alurSection && isInViewport(alurSection)) {
                alurSection.classList.add('visible');
                // Hapus event listener setelah animasi dipicu sekali
                window.removeEventListener('scroll', handleTimelineAnimation);
            }
        }

        // Event listener untuk scroll dan load
        window.addEventListener('scroll', handleTimelineAnimation);
        window.addEventListener('load', handleTimelineAnimation);

        // Function untuk mendeteksi elemen yang terlihat di viewport
function isInViewport(element) {
    const rect = element.getBoundingClientRect();
    return (
        rect.top <= (window.innerHeight || document.documentElement.clientHeight) * 0.85 &&
        rect.bottom >= 0
    );
}

// Function untuk menangani scroll animation about section
function handleAboutAnimation() {
    const aboutSection = document.querySelector('.about');

    if (aboutSection && isInViewport(aboutSection)) {
        aboutSection.classList.add('visible');
        // Hapus event listener setelah animasi dipicu sekali
        window.removeEventListener('scroll', handleAboutAnimation);
    }
}

// Event listener untuk scroll dan load
window.addEventListener('scroll', handleAboutAnimation);
window.addEventListener('load', handleAboutAnimation);  
    </script>
</body>

</html>

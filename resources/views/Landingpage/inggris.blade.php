<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa Inggris</title>
    <link rel="stylesheet" href="{{ asset('css/inggrislandingpage.css') }}">
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
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('M d') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('M d, Y') }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
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
                <p>Our lessons are designed according to international standards (HSK) to ensure measurable progress.</p>
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
        .wave-line {
            overflow: hidden;
            line-height: 0;
        }
        .wave-line svg {
            width: 250%;
            /* dibuat lebar supaya bisa digeser */
            height: 180px;
            animation: waveMove 6s linear infinite;
        }

        @keyframes waveMove {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }


        .footer {
            background: linear-gradient(105deg, #0b2470, #3c1361);
            /* coklat tua → coklat sedang → coklat pasir */
            color: #f1f1f1;
            font-size: 12px;
            font-weight: 100;
            text-align: center;
            padding: 20px 0;
            margin-top: -1px;
        }





        /* About Section */
        .about {
            background: #ffff;
        }

        .about-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
        }

        .about-card {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .about-card:hover {
            transform: translateY(-5px);
        }

        .about-card .icon-wrapper {
            font-size: 2rem;
            color: #ffc107;
            margin-bottom: 1rem;
        }

        .about .highlight {
            color: #012169;
            font-weight: bold;
        }

        /* Alur Pendaftaran */
        .alur {
            background: #1d3fa3;
            position: relative;
            color: white;
        }


        .alur-timeline {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 2rem;
        }

        .step {
            max-width: 200px;
        }

        .step .circle {
            width: 50px;
            height: 50px;
            background: #ffc107;
            color: #010b44;
            font-weight: bold;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0 auto 1rem;
            font-size: 1.2rem;
        }


        .wave-line {
            position: relative;
            width: 100%;



        }

        .wave-line svg {
            display: block;



        }

        .step h3 {
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .step p {
            font-size: 0.9rem;
        }

        /* Filter Button Styles */
        .filter-buttons-wrapper {
            margin-bottom: 2rem;
        }

        .filter-btn {
            padding: 0.5rem 1.5rem;
            margin: 0 0.5rem;
            border: 2px solid #012169;
            background-color: white;
            color: #012169;
            font-weight: 600;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .filter-btn.active {
            background-color: #012169;
            color: white;
        }

        .filter-btn:hover:not(.active) {
            background-color: #f0f0f0;
        }

        /* Program Grid Layout */
        .program-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            justify-content: center;
        }

        /* Program Card Styles with UK Flag Colors */
        .program-card {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            background: white;
            border: 1px solid #e0e0e0;
        }

        .program-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .program-card-image-wrapper {
            position: relative;
            height: 180px;
            overflow: hidden;
        }

        .program-card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .program-card:hover .program-card-img {
            transform: scale(1.05);
        }

        .program-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
        }

        .card-body {
            padding: 1.5rem;
            flex-grow: 1;
        }

        .program-card-title {
            color: #012169;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .program-card-price {
            color: #C8102E;
            font-weight: bold;
            font-size: 1.1rem;
        }

        /* Button Colors */
        .btn-primary {
            background-color: #012169;
            border-color: #012169;
        }

        .btn-danger {
            background-color: #C8102E;
            border-color: #C8102E;
        }

        .btn-primary:hover {
            background-color: #00114d;
            border-color: #00114d;
        }

        .btn-danger:hover {
            background-color: #a50e26;
            border-color: #a50e26;
        }
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
    </script>
</body>

</html>

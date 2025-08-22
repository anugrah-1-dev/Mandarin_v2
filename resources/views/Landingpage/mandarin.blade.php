<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa Mandarin</title>
    <link rel="stylesheet" href="{{ asset('css/mandarinlandingpage.css') }}">
</head>

<body>
    @include('navbar.nav')
    <!-- Hero Carousel -->
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">

                    <img src={{ asset('asset/img/brilliant1.jpg') }} alt="Belajar Bahasa Mandarin 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant2.jpg') }} alt="Belajar Bahasa Mandarin 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant3.jpg') }} alt="Belajar Bahasa Mandarin 3">

                    <img src={{ asset('asset/img/brilliantclass4.jpg') }} alt="Belajar Bahasa Mandarin 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliantclass5.jpg') }} alt="Belajar Bahasa Mandarin 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliantclass3.jpg') }} alt="Belajar Bahasa Mandarin 3">

                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="hero-text">
            <h1>BRILLIANT MANDARIN COURSE</h1>
            <h2>(Kursus Bahasa Mandarin)</h2>
            <p>Kuasai bahasa Mandarin dengan metode interaktif dan pengajar berpengalaman.</p>
        </div>
    </section>

    <!-- PROGRAM SECTION WITH FILTERING -->
    <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>MANDARIN PROGRAM CHOICES</h2>
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


    {{-- About Section --}}
    <section class="about py-5" id="tentang">
        <div class="container text-center" data-aos="fade-up">
            <h2 class="mb-4">Mengapa Memilih Kami?</h2>
            <p class="mb-5">
                Di <strong>Brilliant Mandarin Course</strong>, kami percaya bahwa belajar Bahasa Mandarin adalah
                sebuah petualangan seru. Kami menggabungkan metode pengajaran <span class="highlight">terbaik</span>
                dengan pendekatan interaktif untuk menciptakan pengalaman belajar yang efektif dan tak terlupakan.
            </p>
            <div class="about-grid">
                <div class="about-card" data-aos="fade-up" data-aos-delay="100">
                    <div class="icon-wrapper"><i class="fas fa-rocket"></i></div>
                    <h3>Kurikulum Terstruktur</h3>
                    <p>Materi kami disusun sesuai standar internasional (HSK) untuk memastikan kemajuan Anda terukur.
                    </p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="200">
                    <div class="icon-wrapper"><i class="fas fa-user-tie"></i></div>
                    <h3>Pengajar Profesional</h3>
                    <p>Belajar dari instruktur (Laoshi) berpengalaman, baik native speaker maupun lokal yang
                        bersertifikasi.</p>
                </div>
                <div class="about-card" data-aos="fade-up" data-aos-delay="300">
                    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
                    <h3>Komunitas Aktif</h3>
                    <p>Bergabung dengan komunitas suportif untuk berlatih percakapan dan mendalami budaya bersama.</p>
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


    <!-- Registration Flow Mandarin -->

    <section class="alur-mandarin" id="alur-mandarin">

        <div class="container">
            <h2>报名流程</h2>
            <p>请按照以下步骤在 <strong>Brilliant Mandarin Course</strong> 完成报名：</p>

            <div class="alur-timeline-mandarin">
                <div class="step-mandarin">
                    <div class="circle-mandarin">1</div>
                    <h3>填写报名表</h3>
                    <p>通过我们网站提供的在线表格填写完整的个人信息。</p>
                </div>
                <div class="step-mandarin">
                    <div class="circle-mandarin">2</div>
                    <h3>验证与确认</h3>
                    <p>我们的团队将联系您进行验证并提供进一步的信息。</p>
                </div>
                <div class="step-mandarin">
                    <div class="circle-mandarin">3</div>
                    <h3>支付与上传凭证</h3>
                    <p>根据指示完成付款，然后在确认页面上传转账凭证。</p>
                </div>
                <div class="step-mandarin">
                    <div class="circle-mandarin">4</div>
                    <h3>现场确认</h3>
                    <p>通过我们 Brilliant Mandarin Course 办公室的管理员完成现场确认。</p>
                </div>
                <div class="step-mandarin">
                    <div class="circle-mandarin">5</div>
                    <h3>准备学习！</h3>
                    <p>恭喜！您已成功注册并准备好参加课程。</p>
                </div>
            </div>
        </div>
    </section>


    {{-- JS for Carousel --}}
    <script>
        const slides = document.querySelectorAll(".slide");
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");
        let current = 0;

        function showSlide(index) {
            slides.forEach((s, i) => s.classList.toggle("active", i === index));
        }

        if (prevBtn && nextBtn) {
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
        }
    </script>
    {{-- Bootstrap & AOS JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init({
            once: true, // Animation happens only once
            duration: 800, // Animation duration
        });
    </script>
</body>

</html>
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
        <section class="program-section">
        <div class="container">
            <h2 class="section-title">Program Bahasa Arab</h2>
            <p class="section-subtitle">Pilih program yang sesuai dengan kebutuhan belajar bahasa Arab Anda.</p>

            <div class="program-grid">
                <div class="program-card">
                    <img src="https://picsum.photos/400/250?random=1" alt="Program 1">
                    <h3>Kursus Bahasa Arab Dasar</h3>
                    <p>Belajar huruf hijaiyah, kosa kata dasar, dan percakapan sehari-hari.</p>
                    <a href="#" class="program-btn">Lihat Detail</a>
                </div>

                <div class="program-card">
                    <img src="https://picsum.photos/400/250?random=2" alt="Program 2">
                    <h3>Bahasa Arab Menengah</h3>
                    <p>Pemahaman tata bahasa (nahwu & sharaf) serta percakapan tingkat menengah.</p>
                    <a href="#" class="program-btn">Lihat Detail</a>
                </div>

                <div class="program-card">
                    <img src="https://picsum.photos/400/250?random=3" alt="Program 3">
                    <h3>Bahasa Arab Lanjutan</h3>
                    <p>Fokus membaca teks kitab klasik, percakapan akademik, dan diskusi formal.</p>
                    <a href="#" class="program-btn">Lihat Detail</a>
                </div>
            </div>
        </div>
    </section>

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
  <div class="wave-divider2">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill2"
                d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>
</body>

</html>
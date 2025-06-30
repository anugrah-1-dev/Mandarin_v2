<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Kursus Bahasa Asing | Beranda</title>
  <style>
    :root {
      --primary: #ffffff;
      --secondary: #FFA500;
      --background: rgb(6, 0, 23);
      --text-dark: #000000;
      --text-muted: #CCCCCC;
      --accent: #18005b;
    }

    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--background);
      color: var(--text-dark);
    }

    nav {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background-color: var(--primary);
    }

    .logo {
      display: flex;
      flex-direction: column;
      line-height: 1;
    }

    .logo .top {
      font-size: 1.8rem;
      font-weight: bold;
    }

    .logo .bottom {
      font-size: 1rem;
      font-weight: 500;
      margin-top: 0.2rem;
    }

    .nav-links {
      display: flex;
      gap: 1.5rem;
      align-items: center;
    }

    .nav-links a {
      position: relative;
      text-decoration: none;
      color: var(--text-dark);
      font-weight: 600;
      font-size: 1.05rem;
      padding-bottom: 5px;
      transition: color 0.3s;
    }

    .nav-links a:not(.btn)::after {
      content: "";
      position: absolute;
      left: 0;
      bottom: 0;
      width: 0%;
      height: 3px;
      background-color: var(--accent);
      transition: width 0.3s ease;
    }

    .nav-links a:not(.btn):hover::after {
      width: 100%;
    }

    .nav-links .btn {
      background-color: var(--secondary);
      color: white !important;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      font-weight: bold;
      transition: background-color 0.3s;
    }

    .nav-links .btn:hover {
      background-color: #e69500;
    }

    .carousel {
      position: relative;
      overflow: hidden;
      height: 553px;
      background-color: #000;
    }

    .carousel-container {
      position: relative;
      width: 100%;
      height: 100%;
    }

    .slides {
      width: 100%;
      height: 100%;
      position: relative;
    }

    .slide {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 1s ease;
    }

    .slide.active {
      opacity: 1;
      z-index: 1;
    }

    .overlay {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 2;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
    }

    .carousel-text {
      position: absolute;
      top: 50%;
      left: 5%;
      transform: translateY(-50%);
      z-index: 3;
      color: white;
      max-width: 50%;
    }

    .carousel-text h1 {
      font-size: 3.5rem;
      margin: 0;
    }

    .carousel-text p {
      font-size: 1.2rem;
      margin-top: 1rem;
      color: #e0e0e0;
    }

    .carousel-text .cta-button {
      display: inline-block;
      margin-top: 1.5rem;
      background-color: var(--secondary);
      color: white;
      border: none;
      padding: 0.75rem 1.5rem;
      font-size: 1rem;
      font-weight: bold;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }

    .carousel-text .cta-button:hover {
      background-color: #e69500;
    }

    .nav {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      background-color: rgba(0, 0, 0, 0.5);
      border: none;
      color: white;
      font-size: 2rem;
      padding: 0.5rem 1rem;
      cursor: pointer;
      z-index: 4;
    }

    .prev {
      left: 10px;
    }

    .next {
      right: 10px;
    }

    /* Section Tentang Kami */
    .about {
      background-color: #ffffff;
      color: #333;
      padding: 4rem 2rem;
      text-align: center;
    }

    .about h2 {
      font-size: 2.2rem;
      margin-bottom: 1rem;
      color: var(--accent);
    }

    .about p {
      font-size: 1.1rem;
      max-width: 700px;
      margin: 0 auto;
      line-height: 1.6;
    }

    footer {
      text-align: center;
      padding: 2rem;
      font-size: 0.9rem;
      color: var(--text-muted);
    }

    @media (max-width: 600px) {
      .nav-links {
        flex-direction: column;
        gap: 0.5rem;
      }

      .carousel-text {
        max-width: 90%;
        left: 5%;
      }

      .carousel-text h1 {
        font-size: 2rem;
      }

      .carousel-text p {
        font-size: 1rem;
      }

      .about h2 {
        font-size: 1.6rem;
      }

      .about p {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav>
    <div class="logo">
      <div class="top">BRILLIANT</div>
      <div class="bottom">ENGLISH COURSE</div>
    </div>
    <div class="nav-links">
      <a href="#">BERANDA</a>
      <a href="#">TENTANG KAMI</a>
      <a href="#">PROGRAM & HARGA</a>
      <a href="#">GALERI</a>
      <a href="#" class="btn">PENDAFTARAN</a>
    </div>
  </nav>

  <!-- Carousel -->
  <section class="carousel">
    <div class="carousel-container">
      <div class="slides">
        <img src="{{ asset('asset/img/Astra.Yao.full.4397350.jpg') }}" class="slide active" alt="Slide 1">
        <img src="{{ asset('asset/img/azur-lane-enterprise-anime-girl-uhdpaper.com-4K-4.1756.jpg') }}" class="slide" alt="Slide 2">
        <img src="{{ asset('asset/img/Feixiao.full.4282475.png') }}" class="slide" alt="Slide 3">
      </div>
      <div class="overlay"></div>
      <div class="carousel-text">
        <h1>BRILLIANT ENGLISH COURSE</h1>
        <p>Tingkatkan kemampuan Bahasa Inggris Anda dan rasakan pengalaman belajar yang berkualitas di Brilliant English Course, tempat di mana potensi Anda menjadi lebih gemilang!</p>
        <a href="#daftar" class="cta-button">DAFTAR SEKARANG</a>
      </div>
      <button class="nav prev" onclick="changeSlide(-1)">&#10094;</button>
      <button class="nav next" onclick="changeSlide(1)">&#10095;</button>
    </div>
  </section>

  <!-- Section Tentang Kami -->
  <section class="about">
    <h2>TENTANG KAMI</h2>
    <p>Brilliant English Course adalah salah satu lembaga kursus unggulan di Kampung Inggris Pare yang dikenal dengan metode pembelajaran yang efektif, suasana belajar nyaman, serta fasilitas lengkap yang mendukung proses belajar Bahasa Inggris dari dasar hingga mahir.</p>
  </section>

  <!-- Footer -->
  <footer>
    &copy;  2025 Brilliant English Course. Hak Cipta Dilindungi Oleh Undang-Undang
  </footer>

  <script>
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    function showSlide(index) {
      slides.forEach((slide, i) => {
        slide.classList.remove('active');
        if (i === index) slide.classList.add('active');
      });
    }

    function changeSlide(step) {
      currentSlide = (currentSlide + step + totalSlides) % totalSlides;
      showSlide(currentSlide);
    }

    setInterval(() => {
      changeSlide(1);
    }, 5000);
  </script>

</body>
</html>

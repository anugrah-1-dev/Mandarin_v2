<!-- Navbar -->
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<script>
    const logo1URL = "{{ asset('asset/img/logo1.png') }}";
    const logo2URL = "{{ asset('asset/img/logo2-removebg-preview.png') }}";
</script>
<script src="{{ asset('js/landingpage.js') }}"></script>

<nav id="navbar">
    <div class="logo">
        <img src="{{ asset('asset/img/logo1.png') }}" alt="Logo" style="height: 60px;">
    </div>

    <!-- Burger Menu -->
    <div class="burger" onclick="toggleNavbar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="nav-links" id="navLinks">
        <a href="#tentang">TENTANG KAMI</a>
        <a href="#program">PROGRAM</a>
        <a href="#camp">CAMP</a>
        <a href="#galeri">GALLERI</a>
        <a href="#kontak">KONTAK</a>
        {{-- <a href="#daftar" class="btn">MASUK</a> --}}
    </div>
</nav>

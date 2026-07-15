<!-- Navbar -->
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<script>
    const logo1URL = "{{ asset('asset/img/bietest.png') }}";
    const logo2URL = "{{ asset('asset/img/bietest.png') }}";
</script>
<script src="{{ asset('js/landingpage.js') }}"></script>
<!-- Navbar css-->
<link rel="stylesheet" href="{{ asset('css/nvbr.css') }}">


<nav id="navbar">

    <div class="logo">
        <a href="{{ route('landing') }}">
            @if (request()->routeIs('program.arab'))
                <img src="{{ asset('asset/img/alsaeid logo.png') }}" alt="Logo Arab" style="height: 130px;">
            @elseif (request()->routeIs('program.mandarin'))
                <img src="{{ asset('asset/img/MandarinLogo.png') }}" alt="Logo Mandarin" style="height: 320px;">
            @elseif (request()->routeIs('program.jerman'))
                <img src="{{ asset('asset/img/JermanLogo.png') }}" alt="Logo Jerman" style="height: 95px;">
            @elseif (request()->routeIs('landing.nhc'))
                <img src="{{ asset('asset/img/logonhc.png') }}" alt="Logo NHC" style="height: 95px;">
            @elseif (request()->routeIs('program.inggris'))
                <img src="{{ asset('asset/img/Inggris2.png') }}" alt="Logo Inggris" style="height: 150px;">
            @elseif (request()->routeIs('bieplus.program.inggris', 'bieplus.program.jerman', 'bieplus.program.mandarin', 'bieplus.program.arab'))
                <img src="{{ asset('asset/img/bietest.png') }}" alt="Logo BIE+" style="height: 84px;">
            @else
                @if (request()->routeIs('landing') && isset($navLogo1) && $navLogo1->image_path)
                    <img src="{{ asset('storage/' . $navLogo1->image_path) }}" alt="Logo" style="height: 120px; transform: scale(1.3); margin-left: 20px; object-fit: contain;">
                @else
                    <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Logo Default" style="height: 120px; transform: scale(1.3); margin-left: 20px; object-fit: contain;">
                @endif
            @endif
        </a>
    </div>




    <div class="burger" onclick="toggleNavbar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="nav-links" id="navLinks">

        <a href="{{ url('/#program') }}">PROGRAM</a>



        <a href="{{ url('/#alur-mandarin') }}">KONTAK</a>
        <a href="{{ url('/#tentang') }}">TENTANG KAMI</a>
        <a href="{{ route('tracking.index') }}" class="btn">Tracking Transaksi</a>
    </div>
</nav>
<script>
    // Navbar scroll effect
    window.addEventListener('scroll', function () {
        const navbar = document.getElementById('navbar');
        if (window.scrollY > 50) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    });

    // Dropdown functionality (support multiple dropdowns)
    document.addEventListener('DOMContentLoaded', function () {
        const dropdowns = document.querySelectorAll('.dropdown');

        dropdowns.forEach(dropdown => {
            const button = dropdown.querySelector('.dropbtn');

            if (button) {
                button.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    // Tutup semua dropdown lain dulu
                    dropdowns.forEach(d => {
                        if (d !== dropdown) d.classList.remove('active');
                    });

                    // Toggle dropdown yang diklik
                    dropdown.classList.toggle('active');
                });
            }
        });

        // Close all dropdowns when clicking outside
        document.addEventListener('click', function (e) {
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('active');
                }
            });
        });

        // Close dropdown when item is selected
        document.querySelectorAll('.dropdown-content a').forEach(item => {
            item.addEventListener('click', function () {
                dropdowns.forEach(d => d.classList.remove('active'));
            });
        });
    });

    // Mobile navbar toggle
    function toggleNavbar() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }
</script>
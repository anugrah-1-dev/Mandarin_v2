<!-- Navbar -->
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}">
<script>
    const logo1URL = "{{ asset('asset/img/b2.png') }}";
    const logo2URL = "{{ asset('asset/img/b2.png') }}";
</script>
<script src="{{ asset('js/landingpage.js') }}"></script>
<!-- Navbar css-->
<link rel="stylesheet" href="{{ asset('css/nvbr.css') }}">


<nav id="navbar">

    <div class="logo">
        <a href="{{ route('landing') }}">
            @if (request()->routeIs('program.arab'))
                <img src="{{ asset('asset/img/alsaeid logo.png') }}" alt="Logo Arab" style="height: 150px;">
            @elseif (request()->routeIs('program.mandarin'))
                <img src="{{ asset('asset/img/MandarinLogo.png') }}" alt="Logo Mandarin" style="height: 240px;">
            @elseif (request()->routeIs('program.jerman'))
                <img src="{{ asset('asset/img/JermanLogo.png') }}" alt="Logo Jerman" style="height: 95px;">
            @else
                <img src="{{ asset('asset/img/b2.png') }}" alt="Logo Default" style="height: 75px;">
            @endif
        </a>
    </div>
    



    <div class="burger" onclick="toggleNavbar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="nav-links" id="navLinks">
        <a href="{{ url('/#tentang') }}">TENTANG KAMI</a>


        <div class="dropdown" id="programDropdown">
            <button class="dropbtn">
                PROGRAM <span class="arrow">▼</span>
            </button>
            <div class="dropdown-content">
                <a href="{{ route('program.inggris') }}">Bahasa Inggris</a>
                <a href="{{ route('program.jerman') }}">Bahasa Jerman</a>
                <a href="{{ route('program.mandarin') }}">Bahasa Mandarin</a>
                <a href="{{ route('program.arab') }}">Bahasa Arab</a>
               
            </div>
        </div>

        <a href="{{ url('/#camp') }}">CAMP</a>
        <a href="{{ url('/#galeri') }}">GALLERI</a>
        <a href="{{ url('/#sosmed') }}">SOSMED</a>
        <a href="{{ url('/#kontak') }}">KONTAK</a>
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

    // Dropdown functionality
    document.addEventListener('DOMContentLoaded', function () {
        const dropbtn = document.querySelector('.dropbtn');
        const dropdown = document.getElementById('programDropdown');

        if (dropbtn) {
            dropbtn.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopPropagation();
                dropdown.classList.toggle('active');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target)) {
                dropdown.classList.remove('active');
            }
        });

        // Close dropdown when item is selected
        document.querySelectorAll('.dropdown-content a').forEach(item => {
            item.addEventListener('click', function () {
                dropdown.classList.remove('active');
            });
        });
    });

    // Mobile navbar toggle
    function toggleNavbar() {
        const navLinks = document.getElementById('navLinks');
        navLinks.classList.toggle('active');
    }
</script>
<!-- Navbar -->
<link rel="stylesheet" href="{{ asset('css/navbar.css') }}?v={{ filemtime(public_path('css/navbar.css')) }}">
<script>
    const logo1URL = "{{ $navLogo1 && $navLogo1->image_path ? asset('storage/' . $navLogo1->image_path) : asset('asset/img/LogoWebBrillaintPare.png') }}";
    const logo2URL = "{{ $navLogo2 && $navLogo2->image_path ? asset('storage/' . $navLogo2->image_path) : asset('asset/img/LogoWebBrillaintPare.png') }}";
</script>
<script src="{{ asset('js/landingpage.js') }}?v={{ filemtime(public_path('js/landingpage.js')) }}"></script>
<!-- Navbar css-->
<link rel="stylesheet" href="{{ asset('css/navbarblade.css') }}?v={{ filemtime(public_path('css/navbarblade.css')) }}">



<nav id="navbar">
    <div class="logo" style="display: flex; align-items: center; gap: 10px;">
        @if ($navLogo1 && $navLogo1->image_path)
            <img src="{{ asset('storage/' . $navLogo1->image_path) }}" alt="Logo 1" id="navbarLogo" style="height: 70px;">
        @else
            <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Logo 1" id="navbarLogo" style="height: 70px;">
        @endif

        @if ($navLogo2 && $navLogo2->image_path)
            <img src="{{ asset('storage/' . $navLogo2->image_path) }}" alt="Logo 2" id="navbarLogo2" style="height: 70px;">
        @endif
    </div>

    <div class="burger" onclick="toggleNavbar()">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="nav-links" id="navLinks">


        <div class="dropdown" id="programDropdown">
            <button class="dropbtn" id="openKursusPopupBtn">
                PROGRAM
            </button>
        </div>

        <div class="dropdown" id="galleryDropdown">
            <button class="dropbtn">
                GALERI <span class="arrow">▼</span>
            </button>
            <div class="dropdown-content">
                <a href="#galeri">Galeri</a>
                <a href="#sosmed">Social Media</a>
            </div>
        </div>

        <a href="#camp">CAMP</a>
        {{-- <a href="#galeri">GALLERI</a>
        <a href="#sosmed">SOSMED</a> --}}
        <a href="#kontak">KONTAK</a>
        <a href="#">TENTANG KAMI</a>
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
    document.addEventListener("DOMContentLoaded", function () {
        const openBtn = document.getElementById("openKursusPopupBtn");
        const popup = document.getElementById("kursusPopup");
        const closeBtn = document.getElementById("closeKursusPopupBtn");

        if (openBtn && popup && closeBtn) {
            // buka popup
            openBtn.addEventListener("click", function () {
                popup.classList.add("show");
            });

            // tutup popup
            closeBtn.addEventListener("click", function () {
                popup.classList.remove("show");
            });

            // tutup popup kalau klik luar area
            popup.addEventListener("click", function (e) {
                if (e.target === popup) {
                    popup.classList.remove("show");
                }
            });
        }
    })
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
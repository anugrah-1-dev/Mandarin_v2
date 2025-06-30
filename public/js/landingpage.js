document.addEventListener('DOMContentLoaded', function() {

    // --- Kode Carousel ---
    let currentSlide = 0;
    const slides = document.querySelectorAll('.slide');
    const totalSlides = slides.length;

    // Cek dulu apakah elemen slide ditemukan
    if (slides.length > 0) {
        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.remove('active');
                if (i === index) {
                    slide.classList.add('active');
                }
            });
        }

        function changeSlide(step) {
            currentSlide = (currentSlide + step + totalSlides) % totalSlides;
            showSlide(currentSlide);
        }

        // Jalankan carousel hanya jika ada lebih dari 1 slide
        if (totalSlides > 1) {
            setInterval(() => {
                changeSlide(1);
            }, 5000);
        }
    }


    // --- Kode Sticky Navbar ---
    const navbar = document.getElementById("navbar");
    const carousel = document.getElementById("carousel");

    // Cek dulu apakah elemen navbar dan carousel ditemukan
    if (navbar && carousel) {
        window.addEventListener("scroll", () => {
            const carouselBottom = carousel.offsetTop + carousel.offsetHeight;
            // Angka 80 adalah offset, bisa disesuaikan
            if (window.scrollY > carouselBottom - 80) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    }

});



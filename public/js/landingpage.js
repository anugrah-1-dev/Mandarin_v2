// --- Kode Carousel (IIFE agar tidak konflik variabel global) ---
(function () {
    let currentSlide = 0;
    let slides = [];
    let totalSlides = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.remove("active");
            if (i === index) slide.classList.add("active");
        });
    }

    function changeSlide(step) {
        if (totalSlides === 0) return;
        currentSlide = (currentSlide + step + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }

    // Ekspor ke global supaya bisa dipanggil dari onclick HTML
    window.changeSlide = changeSlide;

    document.addEventListener("DOMContentLoaded", function () {
        slides = document.querySelectorAll(".slide");
        totalSlides = slides.length;

        if (totalSlides > 0) {
            showSlide(currentSlide);

            if (totalSlides > 1) {
                setInterval(() => changeSlide(1), 5000);
            }

            const prevBtn = document.querySelector(".prev");
            const nextBtn = document.querySelector(".next");
            if (prevBtn)
                prevBtn.addEventListener("click", () => changeSlide(-1));
            if (nextBtn)
                nextBtn.addEventListener("click", () => changeSlide(1));
        }

        // --- Sticky Navbar ---
        const navbar = document.getElementById("navbar");
        const carousel = document.getElementById("carousel");

        if (navbar && carousel) {
            window.addEventListener("scroll", () => {
                const carouselBottom =
                    carousel.offsetTop + carousel.offsetHeight;
                const hasScrolled = window.scrollY > carouselBottom - 80;

                if (hasScrolled) {
                    navbar.classList.add("scrolled");
                } else {
                    navbar.classList.remove("scrolled");
                }
            });
        }

        // --- Logo klik scroll ke atas ---
        const logo = document.querySelector("#navbar .logo");
        if (logo) {
            logo.addEventListener("click", function () {
                window.scrollTo({ top: 0, behavior: "smooth" });
            });
        }
    });
})();

function toggleNavbar() {
    const navLinks = document.getElementById("navLinks");
    if (navLinks) navLinks.classList.toggle("active");
}

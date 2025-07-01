// --- Kode Carousel ---
let currentSlide = 0;
let slides = [];
let totalSlides = 0;

function showSlide(index) {
    slides.forEach((slide, i) => {
        slide.classList.remove("active");
        if (i === index) {
            slide.classList.add("active");
        }
    });
}

function changeSlide(step) {
    if (totalSlides === 0) return;
    currentSlide = (currentSlide + step + totalSlides) % totalSlides;
    showSlide(currentSlide);
}

document.addEventListener("DOMContentLoaded", function () {
    // Ambil semua slide setelah halaman siap
    slides = document.querySelectorAll(".slide");
    totalSlides = slides.length;

    if (totalSlides > 0) {
        showSlide(currentSlide);

        // Autoplay setiap 5 detik
        if (totalSlides > 1) {
            setInterval(() => {
                changeSlide(1);
            }, 5000);
        }

        // Event tombol prev/next
        const prevBtn = document.querySelector(".prev");
        const nextBtn = document.querySelector(".next");

        if (prevBtn) {
            prevBtn.addEventListener("click", () => changeSlide(-1));
        }

        if (nextBtn) {
            nextBtn.addEventListener("click", () => changeSlide(1));
        }
    }

    // --- Kode Sticky Navbar ---
    const navbar = document.getElementById("navbar");
    const carousel = document.getElementById("carousel");

    if (navbar && carousel) {
        window.addEventListener("scroll", () => {
            const carouselBottom = carousel.offsetTop + carousel.offsetHeight;
            if (window.scrollY > carouselBottom - 80) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    }
});

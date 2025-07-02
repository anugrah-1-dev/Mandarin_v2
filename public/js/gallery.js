function openLightbox(element) {
    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightboxImg");
    lightboxImg.src = element.src;
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
}

function closeLightbox() {
    document.getElementById("lightbox").classList.remove("active");
    document.body.style.overflow = "auto";
}

window.openLightbox = openLightbox;
window.closeLightbox = closeLightbox;

document.addEventListener("DOMContentLoaded", () => {
    const galleryContainer = document.getElementById("galleryContainer");
    const galleryWrapper = document.querySelector(".gallery-wrapper");

    if (galleryContainer) {
        // ✅ Duplikat isi agar bisa loop
        galleryContainer.innerHTML += galleryContainer.innerHTML;

        // ✅ Scroll ke posisi tengah (awalan dari duplikat)
        galleryWrapper.scrollLeft = galleryContainer.scrollWidth / 2;

        let isDown = false;
        let startX, scrollLeft;

        galleryWrapper.addEventListener("mousedown", (e) => {
            isDown = true;
            galleryWrapper.classList.add("dragging");
            startX = e.pageX - galleryWrapper.offsetLeft;
            scrollLeft = galleryWrapper.scrollLeft;
        });

        galleryWrapper.addEventListener("mouseleave", () => {
            isDown = false;
            galleryWrapper.classList.remove("dragging");
        });

        galleryWrapper.addEventListener("mouseup", () => {
            isDown = false;
            galleryWrapper.classList.remove("dragging");
        });

        galleryWrapper.addEventListener("mousemove", (e) => {
            if (!isDown) return;
            e.preventDefault();
            const x = e.pageX - galleryWrapper.offsetLeft;
            const walk = (x - startX) * 2;
            galleryWrapper.scrollLeft = scrollLeft - walk;
        });

        // ✅ Deteksi saat scroll sampai akhir → reset agar looping
        galleryWrapper.addEventListener("scroll", () => {
            const scrollLeft = galleryWrapper.scrollLeft;
            const totalWidth = galleryContainer.scrollWidth;
            const visibleWidth = galleryWrapper.offsetWidth;

            const half = totalWidth / 2;

            if (scrollLeft <= 0) {
                // Kalau ke kiri terlalu jauh → lompat ke tengah bagian ke-2
                galleryWrapper.scrollLeft = half;
            } else if (scrollLeft >= totalWidth - visibleWidth) {
                // Kalau ke kanan terlalu jauh → lompat balik
                galleryWrapper.scrollLeft = half - visibleWidth;
            }
        });

    } else {
        console.warn("galleryContainer tidak ditemukan!");
    }

    console.log("Infinite drag gallery aktif ✅");
});

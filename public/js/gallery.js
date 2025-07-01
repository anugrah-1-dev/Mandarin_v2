// Fungsi untuk membuka Lightbox (Tetap sama)
function openLightbox(element) {
    console.log("Gambar diklik:", element.src); // ✅ DITAMBAHKAN (debugging)

    const lightbox = document.getElementById("lightbox");
    const lightboxImg = document.getElementById("lightboxImg");

    lightboxImg.src = element.src;
    lightbox.classList.add("active");
    document.body.style.overflow = "hidden";
}

// Fungsi untuk menutup Lightbox
function closeLightbox() {
    const lightbox = document.getElementById("lightbox");
    lightbox.classList.remove("active");
    document.body.style.overflow = "auto";
}

// ✅ DITAMBAHKAN - Agar fungsi bisa dipanggil dari HTML onclick
window.openLightbox = openLightbox;
window.closeLightbox = closeLightbox;

// ✅ DITAMBAHKAN - Debug untuk memastikan JS termuat
console.log("Gallery JS loaded ✅");

// ✅ DITAMBAHKAN - Pastikan DOM sudah siap sebelum menduplikasi
document.addEventListener("DOMContentLoaded", () => {
    const galleryContainer = document.getElementById("galleryContainer");

    if (galleryContainer) {
        // Ambil semua item di dalam container, lalu tambahkan sebagai duplikat
        galleryContainer.innerHTML += galleryContainer.innerHTML;
    } else {
        console.warn("Elemen galleryContainer tidak ditemukan! ❌");
    }
});
    
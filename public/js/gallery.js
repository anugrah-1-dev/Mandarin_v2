/* Kode untuk scroll otomatis sudah tidak diperlukan lagi :) */

// Fungsi untuk membuka Lightbox (Tetap sama)
function openLightbox(element) {
    const lightbox = document.getElementById('lightbox');
    const lightboxImg = document.getElementById('lightboxImg');

    lightboxImg.src = element.src;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

// Fungsi untuk menutup Lightbox (Tetap sama)
function closeLightbox() {
    const lightbox = document.getElementById('lightbox');
    lightbox.classList.remove('active');
    document.body.style.overflow = 'auto';
}

/**
 * TIPS PRO: Duplikasi otomatis dengan JavaScript!
 * Daripada copy-paste manual di HTML, Epang bisa pakai kode ini.
 * Letakkan di dalam tag <script> di bawah kode lightbox.
 */
document.addEventListener('DOMContentLoaded', () => {
    const galleryContainer = document.getElementById('galleryContainer');
    // Ambil semua item di dalam container, lalu tambahkan sebagai duplikat
    galleryContainer.innerHTML += galleryContainer.innerHTML;
});

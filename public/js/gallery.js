// public/js/gallery.js

// ------------------ LIGHTBOX ------------------
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

// ------------------ GALLERY LOOP (FINAL) ------------------
document.addEventListener("DOMContentLoaded", () => {
    const wrapper = document.getElementById("galleryWrapper");
    const container = document.getElementById("galleryContainer");

    if (!wrapper || !container) return;

    const items = Array.from(container.children);
    items.forEach((item) => {
        const clone = item.cloneNode(true);
        container.appendChild(clone);
    });

    const speed = 1.2;

    wrapper.scrollLeft = container.scrollWidth / 2;

    let isDragging = false;
    let startX = 0;
    let scrollStart = 0;
    let animationFrameId = null;

    function loopCheck() {
        const scrollLeft = wrapper.scrollLeft;
        const totalWidth = container.scrollWidth;
        const halfWidth = totalWidth / 2;
        const visibleWidth = wrapper.offsetWidth;

        // Buffer (speed * 2) memastikan kondisi lompat tetap terpenuhi
        if (scrollLeft >= totalWidth - visibleWidth - (speed * 2)) {
            wrapper.scrollLeft -= halfWidth;
        }
        else if (scrollLeft <= 0) {
            wrapper.scrollLeft += halfWidth;
        }
    }

    function autoScroll() {
        if (!isDragging) {
            wrapper.scrollLeft += speed;
            loopCheck();
        }
        animationFrameId = requestAnimationFrame(autoScroll);
    }

    function startAutoScroll() {
        if (!animationFrameId) {
            animationFrameId = requestAnimationFrame(autoScroll);
        }
    }

    function stopAutoScroll() {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
    }

    wrapper.addEventListener("mousedown", (e) => {
        isDragging = true;
        startX = e.pageX;
        scrollStart = wrapper.scrollLeft;
        stopAutoScroll();
        wrapper.classList.add("dragging");
    });

    window.addEventListener("mouseup", () => {
        if (isDragging) {
            isDragging = false;
            wrapper.classList.remove("dragging");
            startAutoScroll();
        }
    });

    window.addEventListener("mousemove", (e) => {
        if (!isDragging) return;
        const walk = (e.pageX - startX) * 1.5;
        wrapper.scrollLeft = scrollStart - walk;
        loopCheck();
    });

    startAutoScroll();
});



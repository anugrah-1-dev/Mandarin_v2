<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kursus Bahasa Inggris</title>
    <link rel="stylesheet" href="{{ asset('css/inggrislandingpage.css') }}">
</head>

<body>
@include('navbar.nav')
    <!-- Hero Carousel -->
    <section class="hero">
        <div class="carousel">
            <div class="slides">
                <div class="slide active">
                    <img src={{ asset('asset/img/brilliant1.jpg') }} alt="Belajar Bahasa Arab 1">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant2.jpg') }} alt="Belajar Bahasa Arab 2">
                </div>
                <div class="slide">
                    <img src={{ asset('asset/img/brilliant3.jpg') }} alt="Belajar Bahasa Arab 3">
                </div>
            </div>
            <button class="prev">&#10094;</button>
            <button class="next">&#10095;</button>
        </div>

        <div class="hero-text">
            <h1>BRILLIANT ENGLISH COURSE</h1>
            <h2>(Kursus Bahasa Inggris)</h2>
            <p>Kuasai bahasa Inggris dengan metode interaktif dan pengajar berpengalaman.</p>

        </div>
    </section>

<!-- PROGRAM SECTION WITH FILTERING -->
<section class="program-section bg-light py-5" id="program">
    <div class="container">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2>ENGLISH PROGRAM CHOICES</h2>
            <p class="lead text-muted">Find the program that best suits your goals.</p>
        </div>

        <div class="filter-buttons-wrapper text-center mb-4" data-aos="fade-up" data-aos-delay="100">
            <button class="filter-btn active" data-filter="offline">Offline Programs</button>
            <button class="filter-btn" data-filter="online">Online Programs</button>
        </div>

        <div class="program-grid">
            <!-- Offline Programs -->
            @forelse ($offlinePrograms as $index => $program)
                <div class="program-item offline" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}" style="display: none;">
                    <div class="program-card">
                        <div class="program-card-image-wrapper">
                            <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                 class="program-card-img"
                                 alt="{{ $program->nama }}">
                            @if ($program->is_active)
                                <span class="badge bg-success program-badge">Available</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                            <p class="card-text text-muted small mb-2">
                                <i class="fas fa-calendar-alt me-1"></i>
                                {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('M d') }} -
                                {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('M d, Y') }}
                            </p>
                            <p class="card-text program-card-price mb-3">
                                Rp {{ number_format($program->harga, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('public.program.offline.show', $program->slug) }}"
                               class="btn btn-primary mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="program-item offline" style="display: none;">
                    <p class="text-muted">No offline programs available</p>
                </div>
            @endforelse

            <!-- Online Programs -->
            @forelse ($onlinePrograms as $index => $program)
                <div class="program-item online" data-aos="fade-up" data-aos-delay="{{ 100 * ($index + 1) }}" style="display: none;">
                    <div class="program-card">
                        <div class="program-card-image-wrapper">
                            <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                 class="program-card-img"
                                 alt="{{ $program->nama }}">
                            @if ($program->is_active)
                                <span class="badge bg-success program-badge">Available</span>
                            @endif
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                            <p class="card-text text-muted small mb-2">
                                <i class="fas fa-tag me-1"></i>
                                Category: {{ $program->kategori ?? '-' }}
                            </p>
                            <p class="card-text program-card-price mb-3">
                                Rp {{ number_format($program->harga, 0, ',', '.') }}
                            </p>
                            <a href="{{ route('public.program.online.show', $program->slug) }}"
                               class="btn btn-danger mt-auto">View Details</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="program-item online" style="display: none;">
                    <p class="text-muted">No online programs available</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

<style>
    /* Filter Button Styles */
    .filter-buttons-wrapper {
        margin-bottom: 2rem;
    }

    .filter-btn {
        padding: 0.5rem 1.5rem;
        margin: 0 0.5rem;
        border: 2px solid #012169; /* Dark blue from UK flag */
        background-color: white;
        color: #012169;
        font-weight: 600;
        border-radius: 30px;
        transition: all 0.3s ease;
    }

    .filter-btn.active {
        background-color: #012169;
        color: white;
    }

    .filter-btn:hover:not(.active) {
        background-color: #f0f0f0;
    }

    /* Program Grid Layout */
    .program-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 2rem;
        justify-content: center;
    }

    /* Program Card Styles with UK Flag Colors */
    .program-card {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        height: 100%;
        display: flex;
        flex-direction: column;
        background: white;
        border: 1px solid #e0e0e0;
    }

    .program-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .program-card-image-wrapper {
        position: relative;
        height: 180px;
        overflow: hidden;
    }

    .program-card-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .program-card:hover .program-card-img {
        transform: scale(1.05);
    }

    .program-badge {
        position: absolute;
        top: 10px;
        right: 10px;
        font-size: 0.8rem;
    }

    .card-body {
        padding: 1.5rem;
        flex-grow: 1;
    }

    .program-card-title {
        color: #012169; /* Dark blue */
        margin-bottom: 0.75rem;
        font-size: 1.1rem;
    }

    .program-card-price {
        color: #C8102E; /* Red from UK flag */
        font-weight: bold;
        font-size: 1.1rem;
    }

    /* Button Colors */
    .btn-primary {
        background-color: #012169;
        border-color: #012169;
    }

    .btn-danger {
        background-color: #C8102E;
        border-color: #C8102E;
    }

    .btn-primary:hover {
        background-color: #00114d;
        border-color: #00114d;
    }

    .btn-danger:hover {
        background-color: #a50e26;
        border-color: #a50e26;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterButtons = document.querySelectorAll('.filter-btn');
        const programItems = document.querySelectorAll('.program-item');

        // Show offline programs by default
        document.querySelector('.filter-btn[data-filter="offline"]').classList.add('active');
        document.querySelectorAll('.program-item.offline').forEach(item => {
            item.style.display = 'block';
        });

        // Filter functionality
        filterButtons.forEach(button => {
            button.addEventListener('click', function() {
                const filterValue = this.getAttribute('data-filter');

                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Show/hide programs
                programItems.forEach(item => {
                    if (item.classList.contains(filterValue)) {
                        item.style.display = 'block';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        });
    });
</script>
\

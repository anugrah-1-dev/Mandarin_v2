<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Brilliant English Course</title>

    {{-- CSS & Fonts --}}
    <link rel="stylesheet" href="{{ asset('css/landingpage.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

    {{-- JS --}}
    <script src="{{ asset('js/landingpage.js') }}" defer></script>
    <script src="{{ asset('js/gallery.js') }}" defer></script>
</head>

<body>
    {{-- Navbar selalu muncul --}}
    @include('navbar.nav')

    {{-- Konten utama landing page --}}
  <section class="program-section bg-light py-5" id="program">
        <div class="container">
            <div class="text-center mb-5" data-aos="fade-up">
                <h2>PILIHAN PROGRAM</h2>
                <p class="lead text-muted">Temukan program yang paling sesuai dengan tujuan Anda.</p>
            </div>

            <div class="filter-buttons-wrapper" data-aos="fade-up" data-aos-delay="100">
                <button class="filter-btn active" data-filter="offline">Program Offline</button>
                <button class="filter-btn" data-filter="online">Program Online</button>
            </div>

            <div class="program-grid">
                @forelse ($offlinePrograms as $index => $program)
                    <div class="program-item" data-filter="offline" data-aos="fade-up"
                         data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="program-card-image-wrapper">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                     class="program-card-img"
                                     alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-calendar-alt me-1"></i>
                                    {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M') }} -
                                    {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.offline.show', $program->slug) }}"
                                   class="btn btn-success mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse

                @forelse ($onlinePrograms as $index => $program)
                    <div class="program-item" data-filter="online" data-aos="fade-up"
                         data-aos-delay="{{ 100 * ($index + 1) }}">
                        <div class="program-card">
                            <div class="position-relative">
                                <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                     class="program-card-img"
                                     alt="{{ $program->nama }}">
                                @if ($program->is_active)
                                    <span class="badge bg-success program-badge">Tersedia</span>
                                @endif
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title program-card-title">{{ $program->nama }}</h5>
                                <p class="card-text text-muted small mb-2">
                                    <i class="fas fa-tag me-1"></i>
                                    Kategori: {{ $program->kategori ?? '-' }}
                                </p>
                                <p class="card-text program-card-price mb-3">
                                    Rp {{ number_format($program->harga, 0, ',', '.') }}
                                </p>
                                <a href="{{ route('public.program.online.show', $program->slug) }}"
                                   class="btn btn-success mt-auto">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>

            <div id="no-program-message" class="text-center text-muted mt-5" style="display: none;">
                <p>Tidak ada program yang tersedia untuk kategori ini.</p>
            </div>
        </div>
    </section>

    <div class="wave-divider4">
        <svg viewBox="0 0 1440 320" preserveAspectRatio="none">
            <path class="shape-fill4"
                  d="M0,224L48,208C96,192,192,160,288,154.7C384,149,480,171,576,186.7C672,203,768,213,864,197.3C960,181,1056,139,1152,122.7C1248,107,1344,117,1392,122.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
            </path>
        </svg>
    </div>

    {{-- Bootstrap & AOS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
</body>
</html>

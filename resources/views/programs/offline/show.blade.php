<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>{{ $program->nama }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery UI Autocomplete Stylesheet -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body class="bg-light">
    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $program->nama }}</h1>
                </div>

                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                @if ($program->thumbnail)
                                    <div class="text-center mb-3">
                                        <img src="{{ asset('storage/' . $program->thumbnail) }}" class="img-fluid rounded"
                                            alt="{{ $program->nama }}">
                                    </div>
                                @endif

                                <table class="table table-bordered">
                                    <tr>
                                        <th class="bg-light">Harga</th>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Jadwal</th>
                                        <td>{{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -
                                            {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Kuota</th>
                                        <td>{{ $program->kuota }}</td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Fasilitas</th>
                                        <td>
                                            @php
                                                $features = $program->features_program;
                                                if (is_string($features)) {
                                                    $decoded = json_decode($features, true);
                                                    $features = json_last_error() === JSON_ERROR_NONE && is_array($decoded)
                                                        ? $decoded
                                                        : explode("\n", $features);
                                                }

                                                function getFeatureIcon($fitur)
                                                {
                                                    $fitur = strtolower($fitur);
                                                    return str_contains($fitur, 'kamar') ? '🛏️' :
                                                        (str_contains($fitur, 'wifi') ? '📶' :
                                                            (str_contains($fitur, 'makan') ? '🍽️' :
                                                                (str_contains($fitur, 'laundry') ? '🧺' :
                                                                    (str_contains($fitur, 'ac') ? '❄️' :
                                                                        (str_contains($fitur, 'parkir') ? '🅿️' : '✅')))));
                                                }
                                            @endphp
                                            @if (!empty($features) && is_array($features))
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($features as $fitur)
                                                        <li>{{ getFeatureIcon($fitur) }} {{ trim($fitur) }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>Tidak ada fasilitas tersedia.</em>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th class="bg-light">Status</th>
                                        <td>
                                            @if($program->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="card border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Formulir Pendaftaran</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Silakan lengkapi data diri Anda untuk mendaftar program ini.
                                </p>
                                <div class="card-body">
                                    @if(session('success'))
                                        <div class="alert alert-success">{{ session('success') }}</div>
                                    @endif

                                    @php
                                        $activePeriods = $periods->where('is_active', 1);
                                    @endphp

                                    <form method="POST"
                                        action="{{ route('public.program.offline.daftar', $program->slug) }}"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-person-fill"></i> Nama
                                                Lengkap</label>
                                            <input type="text" name="nama_lengkap" class="form-control"
                                                value="{{ old('nama_lengkap') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                                            <input type="email" name="email" class="form-control"
                                                value="{{ old('email') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-telephone-fill"></i> No.
                                                HP</label>
                                            <input type="text" name="no_hp" class="form-control"
                                                value="{{ old('no_hp') }}" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Asal
                                                Kota</label>
                                            <input type="text" name="asal_kota" class="form-control"
                                                value="{{ old('asal_kota') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-person-lines-fill"></i> No. HP
                                                Wali</label>
                                            <input type="text" name="no_wali" class="form-control"
                                                value="{{ old('no_wali') }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-bus-front-fill"></i>
                                                Transportasi</label>
                                            <select name="transport_id" class="form-select">
                                                <option value="">Pilih Transportasi</option>
                                                @foreach($transports->where('status', 'active') as $transport)
                                                    <option value="{{ $transport->id }}">{{ $transport->name }}</option>
                                                @endforeach

                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-bank"></i> Bank untuk
                                                Pembayaran</label>
                                            <select name="bank_id" class="form-select" required>
                                                <option value="">Pilih Bank</option>
                                                @if(isset($banks) && $banks->isNotEmpty())
                                                    @foreach($banks as $bank)
                                                        <option value="{{ $bank->id }}">{{ $bank->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="" disabled>Tidak ada pilihan bank tersedia</option>
                                                @endif
                                            </select>
                                            @if(!isset($banks) || $banks->isEmpty())
                                                <div class="form-text text-danger">Pilihan bank tidak tersedia. Hubungi
                                                    admin.</div>
                                            @endif
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="bi bi-calendar-check-fill"></i>
                                                Periode</label>
                                            <select name="period_id" class="form-select" required>
                                                <option value="">Pilih Periode</option>
                                                @if($activePeriods->isNotEmpty())
                                                    @foreach($activePeriods as $period)
                                                        @php
                                                            $startDate = \Carbon\Carbon::parse($period->tanggal_mulai ?? $period->date);
                                                            $endDate = \Carbon\Carbon::parse($period->tanggal_selesai ?? $period->date);
                                                            $periodText = $startDate->isSameDay($endDate)
                                                                ? $startDate->format('d F Y')
                                                                : $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
                                                        @endphp
                                                        <option value="{{ $period->id }}">{{ $periodText }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            @if($activePeriods->isEmpty())
                                                <div class="form-text text-danger">Tidak ada periode pendaftaran yang aktif
                                                    saat ini.</div>
                                            @endif
                                        </div>

                                        <button type="submit" class="btn btn-primary w-100"
                                            @if($activePeriods->isEmpty() || !isset($banks) || $banks->isEmpty())
                                            disabled @endif>
                                            <i class="bi bi-send-fill"></i>
                                            @if($activePeriods->isNotEmpty() && isset($banks) && $banks->isNotEmpty())
                                                Daftar Sekarang
                                            @else
                                                Pendaftaran Ditutup
                                            @endif
                                        </button>
                                        <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-2"><i
                                                class="bi bi-arrow-left"></i> Kembali ke Beranda</a>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery dan jQuery UI (untuk autocomplete) -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Script Autocomplete -->
    <script>
        $(function () {
            $.getJSON('/indonesia-indonesian.json', function (data) {
                let kotaList = [];

                // Gabungkan semua kota/kab dari semua provinsi jadi satu array
                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                // Inisialisasi autocomplete
                $('[name="asal_kota"]').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>

</body>

</html>
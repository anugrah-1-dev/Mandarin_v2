<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $program->nama }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- jQuery UI Autocomplete Stylesheet -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
</head>

<body class="bg-light">
    <div class="container my-4">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Program Title -->
                <div class="text-center mb-4">
                    <h1 class="fw-bold">{{ $program->nama }}</h1>
                </div>

                <div class="row g-4">
                    <!-- Program Info -->
                    <div class="col-12 col-md-6">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th scope="row" class="bg-light">Harga</th>
                                        <td>Rp {{ number_format($program->harga, 0, ',', '.') }}</td>
                                    </tr>
                                    @if (isset($program->jadwal_mulai))
                                        <tr>
                                            <th scope="row" class="bg-light">Jadwal</th>
                                            <td>
                                                {{ \Carbon\Carbon::parse($program->jadwal_mulai)->format('d M Y') }} -
                                                {{ \Carbon\Carbon::parse($program->jadwal_selesai)->format('d M Y') }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <th scope="row" class="bg-light">Fasilitas</th>
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

                                                    return str_contains($fitur, 'kamar') ? '🛏' :
                                                        (str_contains($fitur, 'wifi') ? '📶' :
                                                            (str_contains($fitur, 'makan') ? '🍽' :
                                                                (str_contains($fitur, 'laundry') ? '🧺' :
                                                                    (str_contains($fitur, 'ac') ? '❄' :
                                                                        (str_contains($fitur, 'parkir') ? '🅿' : '✅')))));

                                                }
                                            @endphp
                                            @if (!empty($features) && is_array($features))
                                                <ul class="list-unstyled mb-0">
                                                    @foreach ($features as $fitur)
                                                        <li>{{ getFeatureIcon($fitur) }} {{ trim($fitur, ", \r\n") }}</li>
                                                    @endforeach
                                                </ul>
                                            @else
                                                <em>Tidak ada data fasilitas.</em>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light">Status</th>
                                        <td>
                                            @if ($program->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row" class="bg-light">Thumbnail</th>
                                        <td>
                                            @if ($program->thumbnail)
                                                <img src="{{ asset('storage/' . $program->thumbnail) }}"
                                                    class="img-fluid rounded" alt="{{ $program->nama }}">
                                            @else
                                                <em>Tidak ada thumbnail.</em>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Registration Form -->
                    <div class="col-12 col-md-6">
                        <div class="card border-primary shadow-sm">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0"><i class="bi bi-pencil-square"></i> Formulir Pendaftaran</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted mb-3">Silakan lengkapi data diri Anda untuk mendaftar program ini.
                                </p>

                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                @php
                                    $activePeriods = $periods->where('is_active', 1);
                                @endphp

                                <form method="POST" action="{{ route('public.program.online.daftar', $program->slug) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-person-fill"></i> Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control"
                                            value="{{ old('nama_lengkap') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-envelope-fill"></i> Email</label>
                                        <input type="email" name="email" class="form-control" value="{{ old('email') }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-telephone-fill"></i> No. HP</label>
                                        <input type="text" name="no_hp" class="form-control" value="{{ old('no_hp') }}"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-geo-alt-fill"></i> Asal Kota</label>
                                        <input type="text" name="asal_kota" class="form-control"
                                            value="{{ old('asal_kota') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-bank"></i> Bank untuk
                                            Pembayaran</label>
                                        <select name="bank_id" class="form-select" required>
                                            <option value="">Pilih Bank</option>
                                            @if(isset($banks) && $banks->isNotEmpty())
                                                @foreach($banks as $bank)
                                                    <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>{{ $bank->name }}</option>
                                                @endforeach
                                            @else
                                                <option value="" disabled>Tidak ada pilihan bank tersedia</option>
                                            @endif
                                        </select>
                                        @if(!isset($banks) || $banks->isEmpty())
                                            <div class="form-text text-danger">Pilihan bank tidak tersedia. Hubungi admin.
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label"><i class="bi bi-calendar-check-fill"></i>
                                            Periode</label>
                                        <select name="period_id" class="form-select" required>
                                            <option value="">Pilih Periode</option>
                                            @foreach($activePeriods as $period)
                                                @php
                                                    $startDate = \Carbon\Carbon::parse($period->tanggal_mulai ?? $period->date);
                                                    $endDate = \Carbon\Carbon::parse($period->tanggal_selesai ?? $period->date);
                                                    $periodText = $startDate->isSameDay($endDate)
                                                        ? $startDate->format('d F Y')
                                                        : $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
                                                @endphp
                                                <option value="{{ $period->id }}" {{ old('period_id') == $period->id ? 'selected' : '' }}>{{ $periodText }}</option>
                                            @endforeach
                                        </select>
                                        @if($activePeriods->isEmpty())
                                            <div class="form-text text-danger">Tidak ada periode pendaftaran yang aktif saat
                                                ini.</div>
                                        @endif
                                    </div>

                                    <button type="submit" class="btn btn-primary w-100" @if($activePeriods->isEmpty() || !isset($banks) || $banks->isEmpty()) disabled @endif>
                                        <i class="bi bi-send-fill"></i>
                                        @if($activePeriods->isNotEmpty() && isset($banks) && $banks->isNotEmpty())
                                            Daftar Sekarang
                                        @else
                                            Pendaftaran Ditutup
                                        @endif
                                    </button>
                                </form>
                                <a href="{{ url('/') }}" class="btn btn-outline-secondary w-100 mt-3">
                                    <i class="bi bi-arrow-left"></i> Kembali ke Beranda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery & jQuery UI -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Autocomplete Kota -->
    <script>
        $(function () {
            $.getJSON('/indonesia-indonesian.json', function (data) {
                let kotaList = [];

                for (let provinsi in data) {
                    kotaList = kotaList.concat(data[provinsi]);
                }

                $('[name="asal_kota"]').autocomplete({
                    source: kotaList,
                    minLength: 2
                });
            });
        });
    </script>
</body>

</html>
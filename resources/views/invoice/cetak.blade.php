<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice - {{ $pendaftaran->trx_id }} | Mandarin Center Pare</title>
    <link rel="icon" href="{{ asset('favicon-v3.png') }}" type="image/png">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: Arial, Helvetica, sans-serif; color: #222; background: #e8e8e8; padding: 20px; font-size: 12px; }
        .action-bar { max-width: 800px; margin: 0 auto 16px auto; display: flex; gap: 10px; justify-content: center; align-items: center; padding: 12px 16px; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 9px 20px; border-radius: 7px; font-weight: bold; font-size: 13px; cursor: pointer; border: none; text-decoration: none; transition: opacity 0.2s; }
        .btn-action:hover { opacity: 0.85; }
        .btn-print { background: #1a56db; color: #fff; }
        .btn-download { background: #057a55; color: #fff; }
        .btn-back { background: #6b7280; color: #fff; }
        .invoice-wrap { max-width: 800px; margin: 0 auto; background: #fff; padding: 32px 36px; box-shadow: 0 4px 20px rgba(0,0,0,0.13); border-radius: 4px; position: relative; overflow: hidden; }
        .watermark-text { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%) rotate(-35deg); font-size: 96px; font-weight: 900; color: rgba(0,0,0,0.04); white-space: nowrap; z-index: 0; pointer-events: none; letter-spacing: 8px; }
        .inv-header { display: table; width: 100%; margin-bottom: 18px; position: relative; z-index: 1; }
        .inv-header-left, .inv-header-right { display: table-cell; width: 50%; vertical-align: top; }
        .inv-header-right { text-align: right; }
        .company-logo { height: 62px; width: auto; max-width: 190px; object-fit: contain; margin-bottom: 6px; display: block; }
        .company-name { font-size: 16px; font-weight: 800; color: #1a1a2e; margin-bottom: 2px; }
        .company-info { font-size: 10.5px; color: #555; line-height: 1.65; }
        .inv-title { font-size: 34px; font-weight: 900; color: #1a1a2e; letter-spacing: 3px; line-height: 1; }
        .inv-meta-table { margin-top: 8px; margin-left: auto; border-collapse: collapse; }
        .inv-meta-table td { padding: 2px 0; font-size: 11px; vertical-align: top; }
        .inv-meta-table td:first-child { color: #666; padding-right: 8px; white-space: nowrap; }
        .inv-meta-table td:last-child { font-weight: 600; color: #222; }
        .status-badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-weight: 700; font-size: 10px; text-transform: uppercase; letter-spacing: 0.5px; }
        .status-diterima { background: #d1fae5; color: #065f46; border: 1px solid #a7f3d0; }
        .status-menunggu { background: #fef3c7; color: #92400e; border: 1px solid #fde68a; }
        .status-gagal { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .divider { border: none; border-top: 2px solid #e5e7eb; margin: 14px 0; }
        .divider-bold { border-top-color: #1a1a2e; border-top-width: 3px; }
        .inv-info { display: table; width: 100%; margin-bottom: 16px; position: relative; z-index: 1; }
        .inv-info-left, .inv-info-right { display: table-cell; width: 50%; vertical-align: top; font-size: 11px; line-height: 1.7; }
        .inv-info-right { text-align: right; }
        .inv-info-label { font-size: 9.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.8px; color: #6b7280; margin-bottom: 5px; }
        .inv-info-value { color: #111; font-size: 11.5px; }
        .inv-info-value strong { font-size: 13px; display: block; }
        .invoice-items { width: 100%; border-collapse: collapse; margin-bottom: 12px; position: relative; z-index: 1; font-size: 11px; }
        .invoice-items thead tr { background: #1a1a2e; color: #fff; }
        .invoice-items th { padding: 7px 8px; font-weight: 700; font-size: 10.5px; }
        .invoice-items tbody tr:nth-child(even) { background: #f9fafb; }
        .invoice-items td { padding: 6px 8px; border-bottom: 1px solid #e5e7eb; vertical-align: top; color: #333; }
        .invoice-items td .item-name { font-weight: 600; color: #111; display: block; }
        .invoice-items td .item-note { color: #6b7280; font-size: 10px; display: block; }
        .invoice-items tbody tr:last-child td { border-bottom: none; }
        .summary-wrap { display: table; width: 100%; margin-top: 4px; position: relative; z-index: 1; }
        .summary-spacer { display: table-cell; width: 56%; }
        .summary-block { display: table-cell; width: 44%; vertical-align: top; }
        .summary-table { width: 100%; border-collapse: collapse; font-size: 11px; }
        .summary-table td { padding: 4px 6px; vertical-align: middle; }
        .summary-table td:first-child { color: #555; }
        .summary-table td:last-child { text-align: right; font-weight: 600; color: #222; }
        .summary-table .total-row { border-top: 2.5px solid #1a1a2e; font-size: 14px; }
        .summary-table .total-row td { padding-top: 8px; font-weight: 800; color: #1a1a2e; }
        .arrival-box { background: #eff6ff; border: 1.5px solid #93c5fd; border-radius: 8px; padding: 10px 14px; margin-bottom: 10px; font-size: 10.5px; line-height: 1.7; color: #1e3a5f; position: relative; z-index: 1; }
        .arrival-box .arrival-title { font-weight: 800; font-size: 11.5px; color: #1d4ed8; margin-bottom: 5px; }
        .arrival-box p { margin-top: 3px; }
        .notes-box { margin-top: 10px; padding: 8px 12px; border-left: 3px solid #f59e0b; background: #fffbeb; border-radius: 0 6px 6px 0; font-size: 10.5px; line-height: 1.7; position: relative; z-index: 1; }
        .notes-box .notes-title { font-weight: 800; font-size: 11px; color: #92400e; margin-bottom: 4px; }
        .notes-box ol { padding-left: 16px; margin: 0; }
        .notes-box li { margin-bottom: 2px; color: #78350f; }
        .inv-closing { text-align: center; margin-top: 14px; padding-top: 12px; border-top: 1px dashed #d1d5db; font-size: 12px; font-weight: 700; color: #1a1a2e; font-style: italic; position: relative; z-index: 1; }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        @media print {
            body { background: #fff; padding: 0; margin: 0; }
            .action-bar { display: none !important; }
            .invoice-wrap { box-shadow: none; border-radius: 0; padding: 16px 20px; max-width: 100%; }
            .watermark-text { color: rgba(0,0,0,0.05) !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .invoice-items thead tr { background: #1a1a2e !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .arrival-box { background: #dbeafe !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .notes-box { background: #fffbeb !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            @page { size: A4 portrait; margin: 10mm 12mm; }
        }
    </style>
</head>
<body>

    <div class="action-bar">
        <button onclick="window.print()" class="btn-action btn-print">&#128438; Print Invoice</button>
        <button onclick="downloadPDF()" id="btn-download" class="btn-action btn-download">&#11015; Download PDF</button>
        <a href="javascript:history.back()" class="btn-action btn-back">&#8592; Kembali</a>
    </div>

    <div class="invoice-wrap" id="invoice-content">
        <div class="watermark-text">BRILLIANT</div>

        {{-- HEADER --}}
        <div class="inv-header">
            <div class="inv-header-left">
                @php
                    $navLogo1 = \App\Models\Logo::where('key', 'logo1')->first();
                @endphp
                @if ($navLogo1 && $navLogo1->image_path)
                    <img src="{{ asset('storage/' . $navLogo1->image_path) }}" alt="Brilliant Logo" class="company-logo">
                @else
                    <img src="{{ asset('asset/img/LogoWebBrillaintPare.png') }}" alt="Brilliant Logo" class="company-logo">
                @endif
                <div class="company-name">MANDARIN CENTER PARE</div>
                <div class="company-info">
                    Pusat Pembelajaran Bahasa Mandarin<br>
                    Kampung Inggris, Pare, Kediri &mdash; Jawa Timur<br>
                    Web: mandarincenterpare.com
                </div>
            </div>
            <div class="inv-header-right">
                <div class="inv-title">INVOICE</div>
                <table class="inv-meta-table">
                    <tr><td>Nomor</td><td>: {{ $pendaftaran->trx_id }}</td></tr>
                    <tr><td>Tanggal</td><td>: {{ \Carbon\Carbon::parse($pendaftaran->created_at)->locale('id')->isoFormat('D MMMM Y') }}</td></tr>
                    <tr><td>Tipe</td><td>: Program {{ $tipe }}</td></tr>
                    <tr>
                        <td>Status</td>
                        <td>:&nbsp;
                            @php $st = strtolower($pendaftaran->status ?? ''); @endphp
                            @if(in_array($st, ['success','berhasil','aktif','diterima','lunas','verified']))
                                <span class="status-badge status-diterima">&#10003; DITERIMA</span>
                            @elseif(in_array($st, ['pending','menunggu','uploaded']))
                                <span class="status-badge status-menunggu">&#9203; MENUNGGU</span>
                            @else
                                <span class="status-badge status-gagal">{{ strtoupper($pendaftaran->status ?? 'UNKNOWN') }}</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="divider divider-bold">

        {{-- INFO PELANGGAN --}}
        <div class="inv-info">
            <div class="inv-info-left">
                <div class="inv-info-label">&#128100; Ditagihkan Kepada</div>
                <div class="inv-info-value">
                    <strong>{{ $customer['nama'] }}</strong>
                    {{ $customer['email'] }}<br>
                    Telp/WA: {{ $customer['no_hp'] }}<br>
                    Kota Asal: {{ $customer['alamat'] }}
                </div>
            </div>
            <div class="inv-info-right">
                <div class="inv-info-label">&#128179; Metode Pembayaran</div>
                <div class="inv-info-value">
                    @if(($pendaftaran->payment_type ?? '') == 'transfer' && $pendaftaran->bank)
                        Transfer Bank<br>
                        <strong>{{ $pendaftaran->bank->name }}</strong>
                        No. Rek: {{ $pendaftaran->bank->number }}<br>
                        a.n {{ $pendaftaran->bank->owner }}
                        @php
                            $invTransport    = ($tipe === 'Offline') ? ($pendaftaran->transport ?? null) : null;
                            $invHasTransBank = $invTransport && ($invTransport->bank_number ?? false);
                        @endphp
                        @if($invHasTransBank)
                            <br><small style="color:#888">+ Transfer Transport (rek. terpisah)</small>
                        @endif
                    @else
                        <strong>Tunai (Cash)</strong><br><small>Bayar di Kantor Brilliant</small>
                    @endif
                </div>
            </div>
        </div>

        <hr class="divider">

        {{-- TABEL ITEM --}}
        <table class="invoice-items">
            <thead>
                <tr>
                    <th class="text-center" style="width:4%">No</th>
                    <th style="width:44%">Deskripsi Item</th>
                    <th class="text-center" style="width:10%">Qty</th>
                    <th class="text-right" style="width:21%">Harga Satuan</th>
                    <th class="text-right" style="width:21%">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>
                        <span class="item-name">{{ $item['nama'] }}</span>
                        <span class="item-note">{{ $item['keterangan'] }}</span>
                    </td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- SUMMARY --}}
        @php
            $invTransportSum    = ($tipe === 'Offline') ? ($pendaftaran->transport ?? null) : null;
            $invHasTransBankSum = $invTransportSum && ($invTransportSum->bank_number ?? false);
            $invTransportPrice  = $invTransportSum ? $invTransportSum->price : 0;
            $invTotalProgram    = $invHasTransBankSum ? ($subtotal - $invTransportPrice) : $subtotal;
        @endphp
        <div class="summary-wrap">
            <div class="summary-spacer"></div>
            <div class="summary-block">
                <table class="summary-table">
                    @if($invHasTransBankSum)
                    <tr><td>Transfer Program</td><td>Rp {{ number_format($invTotalProgram, 0, ',', '.') }}</td></tr>
                    <tr><td>Transfer Transport</td><td>Rp {{ number_format($invTransportPrice, 0, ',', '.') }}</td></tr>
                    @else
                    <tr><td>Subtotal</td><td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td></tr>
                    @endif
                    <tr class="total-row">
                        <td>TOTAL BAYAR</td>
                        <td>Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <hr class="divider" style="margin-top: 16px;">

        {{-- INFO KEDATANGAN --}}
        <div class="arrival-box">
            <div class="arrival-title">&#128226; Informasi Penting Kedatangan</div>
            <p>Anda harus tiba di <strong>Brilliant 1&ndash;2 hari sebelum tanggal mulai program</strong>.
            Akan diadakan <strong>Placement Test Kemampuan Bahasa</strong> dan proses masuk asrama sebelum program dimulai.</p>
            <p>&#128203; <strong>Harap cetak invoice ini dan tunjukkan ke Front Office Brilliant</strong> saat daftar ulang dan pelunasan.</p>
        </div>

        {{-- CATATAN --}}
        <div class="notes-box">
            <div class="notes-title">&#9888; Catatan Penting:</div>
            <ol>
                <li>Faktur ini sah dan diterbitkan secara elektronik, tidak memerlukan tanda tangan basah.</li>
                <li>Uang yang sudah dibayarkan tidak dapat dikembalikan (<em>non-refundable</em>).</li>
                <li>Harap simpan invoice ini sebagai bukti sah pendaftaran Anda.</li>
                <li>Kode unik pada total pembayaran adalah identifikasi transaksi Anda &mdash; jangan dibulatkan.</li>
                <li>Untuk pertanyaan, hubungi admin melalui WhatsApp yang tertera di website.</li>
            </ol>
        </div>

        <div class="inv-closing">
            &#127881; Terima kasih! Selamat datang di Brilliant Family &nbsp;&mdash;&nbsp; We Are Big Family!
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function downloadPDF() {
            var element = document.getElementById('invoice-content');
            var opt = {
                margin: [8, 8, 8, 8],
                filename: 'Invoice_{{ $pendaftaran->trx_id }}.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, scrollY: 0, logging: false },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak: { mode: 'avoid-all' }
            };
            var btn = document.getElementById('btn-download');
            var orig = btn.innerHTML;
            btn.innerHTML = '&#9203; Memproses...';
            btn.disabled = true;
            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = orig;
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>

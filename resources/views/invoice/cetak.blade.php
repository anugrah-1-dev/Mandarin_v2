<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $pendaftaran->trx_id }}</title>
    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 16px;
            font-size: 12px;
            background: #f0f0f0;
        }

        .action-buttons {
            text-align: center;
            margin-bottom: 14px;
            padding: 12px;
            background: #fff;
            border-bottom: 1px solid #ddd;
            border-radius: 6px;
        }
        .btn {
            display: inline-block;
            padding: 8px 18px;
            margin: 0 6px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            font-size: 13px;
        }
        .btn-success { background-color: #198754; }
        .btn:hover { opacity: 0.9; }

        .invoice-container {
            max-width: 780px;
            margin: auto;
            padding: 20px 24px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0,0,0,0.12);
            background-color: #fff;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 80px;
            color: rgba(200,200,200,0.12);
            z-index: 0;
            white-space: nowrap;
            pointer-events: none;
        }

        /* ---- Header ---- */
        .inv-header {
            display: table;
            width: 100%;
            margin-bottom: 12px;
            position: relative;
            z-index: 1;
        }
        .inv-header-left, .inv-header-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
        }
        .inv-header-right { text-align: right; }
        .inv-title {
            font-size: 26px;
            font-weight: bold;
            color: #333;
            line-height: 1;
        }
        .inv-header-left h2 {
            margin: 0 0 4px;
            font-size: 18px;
            color: #0d6efd;
        }
        .inv-header-left p {
            margin: 2px 0;
            color: #555;
            font-size: 11px;
            line-height: 1.5;
        }
        .inv-header-right p {
            margin: 3px 0;
            font-size: 11px;
        }

        /* ---- Status badge ---- */
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 10px;
        }
        .status-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .status-failed  { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        /* ---- Customer / Payment info ---- */
        .inv-info {
            display: table;
            width: 100%;
            border-top: 2px solid #eee;
            border-bottom: 1px solid #eee;
            padding: 8px 0;
            margin-bottom: 10px;
            position: relative;
            z-index: 1;
        }
        .inv-info-left, .inv-info-right {
            display: table-cell;
            width: 50%;
            vertical-align: top;
            font-size: 11px;
            line-height: 1.6;
            padding: 0 4px;
        }
        .inv-info-right { text-align: right; }
        .inv-info strong { font-size: 11px; }

        /* ---- Items table ---- */
        .invoice-items {
            width: 100%;
            border-collapse: collapse;
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            margin-bottom: 8px;
            position: relative;
            z-index: 1;
            font-size: 11px;
        }
        .invoice-items th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
            padding: 5px 6px;
        }
        .invoice-items td {
            padding: 4px 6px;
            border-bottom: 1px solid #eee;
            vertical-align: top;
        }
        .invoice-items tr:last-child td { border-bottom: none; }
        .invoice-items small { color: #666; font-size: 10px; }

        /* ---- Summary ---- */
        .summary-table {
            width: 42%;
            float: right;
            border-collapse: collapse;
            font-size: 11px;
            position: relative;
            z-index: 1;
        }
        .summary-table td { padding: 3px 6px; }
        .summary-table .total-row {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 13px;
        }

        /* ---- Footer ---- */
        .inv-footer {
            clear: both;
            margin-top: 12px;
            padding-top: 10px;
            border-top: 1px solid #eee;
            font-size: 10px;
            color: #666;
            position: relative;
            z-index: 1;
        }
        .arrival-box {
            padding: 8px 12px;
            background: linear-gradient(135deg, #e8f0fe, #d0e4ff);
            border: 1.5px solid #3a7bd5;
            border-radius: 8px;
            margin-bottom: 8px;
            color: #1a1a2e;
        }
        .arrival-box p { margin: 0 0 4px; font-size: 10px; line-height: 1.6; }
        .arrival-box .arrival-title { font-size: 11px; font-weight: bold; color: #1a3c8f; margin-bottom: 4px; }
        .inv-footer .notes p { margin: 2px 0; }
        .inv-footer .closing {
            margin-top: 8px;
            font-size: 12px;
            font-weight: bold;
            color: #1a3c8f;
            font-style: italic;
            text-align: center;
        }

        /* ---- TEXT helpers ---- */
        .text-right  { text-align: right; }
        .text-center { text-align: center; }

        /* ======= PRINT ======= */
        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
                font-size: 11px;
            }
            .action-buttons { display: none !important; }
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 10px 14px;
                max-width: 100%;
            }
            .watermark {
                color: rgba(200,200,200,0.18) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .invoice-items th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .arrival-box {
                background: #e8f0fe !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            /* Paksa 1 halaman */
            html, body { height: 100%; }
            .invoice-container { page-break-inside: avoid; }
            @page {
                size: A4 portrait;
                margin: 10mm 12mm;
            }
        }
    </style>
</head>
<body>

    <div class="action-buttons">
        <button onclick="window.print()" class="btn">&#128438; Print Invoice</button>
        <button onclick="downloadPDF()" id="btn-download" class="btn btn-success">&#11015; Download PDF</button>
    </div>

    <div class="invoice-container" id="invoice-content">
        <div class="watermark">BRILLIANT</div>

        {{-- ===== HEADER ===== --}}
        <div class="inv-header">
            <div class="inv-header-left">
                <h2>BRILLIANT</h2>
                <p>
                    Pusat Pembelajaran Bahasa Asing<br>
                    Kampung Inggris Pare<br>
                    Telp: 0812-3456-7890<br>
                    Website: https://kekampunginggris.com/
                </p>
            </div>
            <div class="inv-header-right">
                <div class="inv-title">INVOICE</div>
                <p><strong>Nomor:</strong> {{ $pendaftaran->trx_id }}</p>
                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d F Y') }}</p>
                <p>
                    <strong>Status:</strong>
                    @php $st = strtolower($pendaftaran->status); @endphp
                    @if(in_array($st, ['success','berhasil','aktif','diterima']))
                        <span class="status-badge status-success">DITERIMA</span>
                    @elseif($st == 'pending')
                        <span class="status-badge status-pending">MENUNGGU</span>
                    @else
                        <span class="status-badge status-failed">{{ strtoupper($pendaftaran->status) }}</span>
                    @endif
                </p>
            </div>
        </div>

        {{-- ===== INFO PELANGGAN & PEMBAYARAN ===== --}}
        <div class="inv-info">
            <div class="inv-info-left">
                <strong>DITAGIHKAN KEPADA:</strong><br>
                {{ $customer['nama'] }}<br>
                {{ $customer['email'] }}<br>
                {{ $customer['no_hp'] }}<br>
                {{ $customer['alamat'] }}
            </div>
            <div class="inv-info-right">
                <strong>METODE PEMBAYARAN:</strong><br>
                @if($pendaftaran->payment_type == 'transfer' && $pendaftaran->bank)
                    Transfer Bank — {{ $pendaftaran->bank->name }}<br>
                    {{ $pendaftaran->bank->number }} a.n {{ $pendaftaran->bank->owner }}
                    @php
                        $invTransport    = $pendaftaran->transport ?? null;
                        $invHasTransBank = $invTransport && ($invTransport->bank_number ?? false);
                    @endphp
                    @if($invHasTransBank)
                        <br><strong>Rek. Transport:</strong><br>
                        {{ $invTransport->bank_name }}<br>
                        {{ $invTransport->bank_number }} a.n {{ $invTransport->bank_owner }}
                    @endif
                @elseif($pendaftaran->payment_type == 'qris')
                    QRIS
                @else
                    Tunai (Cash)
                @endif
            </div>
        </div>

        {{-- ===== TABEL ITEM ===== --}}
        <table class="invoice-items">
            <thead>
                <tr>
                    <th style="width:4%">No</th>
                    <th style="width:42%">Deskripsi Item</th>
                    <th style="width:12%" class="text-center">Qty</th>
                    <th style="width:21%" class="text-right">Harga Satuan</th>
                    <th style="width:21%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item['nama'] }}</strong><br>
                        <small>{{ $item['keterangan'] }}</small>
                    </td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{-- ===== SUMMARY ===== --}}
        @php
            $invTransportSum    = $pendaftaran->transport ?? null;
            $invHasTransBankSum = $invTransportSum && ($invTransportSum->bank_number ?? false);
            $invTransportPrice  = $invTransportSum ? $invTransportSum->price : 0;
            $invTotalProgram    = $invHasTransBankSum ? ($subtotal - $invTransportPrice) : $subtotal;
        @endphp
        <table class="summary-table">
            @if($invHasTransBankSum)
            <tr>
                <td class="text-right"><strong>Transfer Program:</strong></td>
                <td class="text-right" style="width:38%">Rp {{ number_format($invTotalProgram, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Transfer Transport:</strong></td>
                <td class="text-right">Rp {{ number_format($invTransportPrice, 0, ',', '.') }}</td>
            </tr>
            @else
            <tr>
                <td class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right" style="width:38%">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td class="text-right">TOTAL BAYAR:</td>
                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="clear:both; margin-bottom:10px;"></div>

        {{-- ===== FOOTER ===== --}}
        <div class="inv-footer">
            <div class="arrival-box">
                <p class="arrival-title">📢 Informasi Penting Kedatangan</p>
                <p>Kamu harus datang di <strong>Brilliant 2 atau 1 hari sebelum tanggal Start Program dimulai.</strong>
                Dikarenakan akan ada <strong>Placement Tes Kemampuan Bahasa Inggris</strong> dan akan masuk asrama sebelum tanggal program dimulai.</p>
                <p>📄 <strong>Harap cetak invoice ini dan tunjukkan di Front Office Brilliant</strong> ketika daftar ulang dan pelunasan.</p>
            </div>

            <div class="notes">
                <p><strong>Catatan Penting:</strong></p>
                <p>1. Faktur ini sah dan diterbitkan secara elektronik tanpa tanda tangan basah.</p>
                <p>2. Uang yang sudah dibayarkan tidak dapat dikembalikan (non-refundable).</p>
                <p>3. Harap simpan invoice ini sebagai bukti sah pendaftaran Anda.</p>
            </div>

            <p class="closing">🎉 Thank you, Welcome to Brilliant! &nbsp;—&nbsp; We Are Big Family!</p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"
        integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function downloadPDF() {
            var element = document.getElementById('invoice-content');
            var opt = {
                margin:      [8, 8, 8, 8], // mm
                filename:    'Invoice_{{ $pendaftaran->trx_id }}.pdf',
                image:       { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true, scrollY: 0 },
                jsPDF:       { unit: 'mm', format: 'a4', orientation: 'portrait' },
                pagebreak:   { mode: 'avoid-all' }
            };

            var btn = document.getElementById('btn-download');
            var orig = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            btn.disabled = true;

            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = orig;
                btn.disabled = false;
            });
        }
    </script>
</body>
</html>

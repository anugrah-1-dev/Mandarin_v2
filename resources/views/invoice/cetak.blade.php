<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Invoice - {{ $pendaftaran->trx_id }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
            font-size: 14px;
        }

        .invoice-container {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
            background-color: #fff;
            position: relative;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(200, 200, 200, 0.15);
            z-index: 0;
            white-space: nowrap;
            pointer-events: none;
        }

        table {
            width: 100%;
            line-height: inherit;
            text-align: left;
            border-collapse: collapse;
            z-index: 1;
            position: relative;
        }

        table td, table th {
            padding: 8px;
            vertical-align: top;
        }

        .header-table td {
            padding-bottom: 20px;
        }

        .header-table .title {
            font-size: 32px;
            line-height: 32px;
            color: #333;
            text-align: right;
            font-weight: bold;
        }

        .customer-info {
            margin-bottom: 30px;
            border-top: 2px solid #eee;
            padding-top: 15px;
            position: relative;
            z-index: 1;
        }

        .customer-info p {
            margin: 2px 0;
        }

        .invoice-items {
            border-top: 2px solid #333;
            border-bottom: 2px solid #333;
            margin-bottom: 20px;
            position: relative;
            z-index: 1;
        }

        .invoice-items th {
            background-color: #f8f9fa;
            border-bottom: 1px solid #ddd;
            font-weight: bold;
        }

        .invoice-items td {
            border-bottom: 1px solid #eee;
        }

        .invoice-items tr:last-child td {
            border-bottom: none;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .summary-table {
            width: 50%;
            float: right;
            position: relative;
            z-index: 1;
        }

        .summary-table td {
            padding: 5px 8px;
        }

        .summary-table .total-row {
            border-top: 2px solid #333;
            font-weight: bold;
            font-size: 16px;
        }

        .footer {
            clear: both;
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #777;
            position: relative;
            z-index: 1;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 12px;
        }
        
        .status-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status-pending { background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; }
        .status-failed { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }

        .action-buttons {
            text-align: center;
            margin-bottom: 20px;
            padding: 20px;
            background: #f8f9fa;
            border-bottom: 1px solid #ddd;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 0 10px;
            background-color: #0d6efd;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            border: none;
        }
        .btn-success {
            background-color: #198754;
        }
        .btn:hover {
            opacity: 0.9;
        }

        @media print {
            body {
                background: none;
                margin: 0;
                padding: 0;
            }
            .action-buttons {
                display: none;
            }
            .invoice-container {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            .watermark {
                color: rgba(200, 200, 200, 0.2) !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
            th {
                background-color: #f8f9fa !important;
                -webkit-print-color-adjust: exact; 
                print-color-adjust: exact; 
            }
        }
    </style>
</head>
<body>

    <div class="action-buttons">
        <button onclick="window.print()" class="btn">Print Invoice</button>
        <button onclick="downloadPDF()" id="btn-download" class="btn btn-success">Download PDF</button>
    </div>

    <div class="invoice-container" id="invoice-content">
        <!-- Watermark -->
        <div class="watermark">BRILLIANT</div>

        <table class="header-table">
            <tr>
                <td style="width: 50%;">
                    <!-- Ganti src dengan asset logo asli jika ada, contoh: asset('asset/images/logo.png') -->
                    <h2 style="margin:0; color:#0d6efd;">BRILLIANT</h2>
                    <p style="margin:5px 0 0; color:#555;">
                        Pusat Pembelajaran Bahasa Asing<br>
                        Kampung Inggris Pare<br>
                        Telp: 0812-3456-7890
                    </p>
                </td>
                <td style="width: 50%;" class="text-right">
                    <div class="title">INVOICE</div>
                    <p style="margin:10px 0 0;"><strong>Nomor:</strong> {{ $pendaftaran->trx_id }}</p>
                    <p style="margin:2px 0 0;"><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($pendaftaran->created_at)->format('d F Y') }}</p>
                    <p style="margin:2px 0 0;">
                        <strong>Status:</strong> 
                        @if(strtolower($pendaftaran->status) == 'success' || strtolower($pendaftaran->status) == 'berhasil' || strtolower($pendaftaran->status) == 'aktif')
                            <span class="status-badge status-success">BERHASIL</span>
                        @elseif(strtolower($pendaftaran->status) == 'pending')
                            <span class="status-badge status-pending">MENUNGGU</span>
                        @else
                            <span class="status-badge status-failed">{{ strtoupper($pendaftaran->status) }}</span>
                        @endif
                    </p>
                </td>
            </tr>
        </table>

        <div class="customer-info">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;">
                        <strong>DITAGIHKAN KEPADA:</strong><br>
                        {{ $customer['nama'] }}<br>
                        {{ $customer['email'] }}<br>
                        {{ $customer['no_hp'] }}<br>
                        {{ $customer['alamat'] }}
                    </td>
                    <td style="width: 50%;" class="text-right">
                        <strong>METODE PEMBAYARAN:</strong><br>
                        @if($pendaftaran->payment_type == 'transfer' && $pendaftaran->bank)
                            Transfer Bank - {{ $pendaftaran->bank->name }}<br>
                            {{ $pendaftaran->bank->number }} a.n {{ $pendaftaran->bank->owner }}
                            @php
                                $invTransport    = isset($pendaftaran->transport) ? $pendaftaran->transport : null;
                                $invHasTransBank = $invTransport && $invTransport->bank_number;
                            @endphp
                            @if ($invHasTransBank)
                                <br><br>
                                <strong>REKENING TRANSPORTASI:</strong><br>
                                {{ $invTransport->bank_name }}<br>
                                {{ $invTransport->bank_number }} a.n {{ $invTransport->bank_owner }}
                            @endif
                        @elseif($pendaftaran->payment_type == 'qris')
                            QRIS
                        @else
                            Tunai (Cash)
                        @endif
                    </td>
                </tr>
            </table>
        </div>

        <table class="invoice-items">
            <thead>
                <tr>
                    <th style="width: 5%;">No</th>
                    <th style="width: 40%;">Deskripsi Item</th>
                    <th style="width: 15%;" class="text-center">Kuantitas</th>
                    <th style="width: 20%;" class="text-right">Harga Satuan</th>
                    <th style="width: 20%;" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item['nama'] }}</strong><br>
                        <small style="color: #666;">{{ $item['keterangan'] }}</small>
                    </td>
                    <td class="text-center">{{ $item['qty'] }}</td>
                    <td class="text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="text-right">Rp {{ number_format($item['total'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <table class="summary-table">
            @php
                $invTransportSum    = isset($pendaftaran->transport) ? $pendaftaran->transport : null;
                $invHasTransBankSum = $invTransportSum && $invTransportSum->bank_number;
                $invTransportPrice  = $invTransportSum ? $invTransportSum->price : 0;
                $invTotalProgram    = $invHasTransBankSum ? ($subtotal - $invTransportPrice) : $subtotal;
            @endphp
            @if ($invHasTransBankSum)
            <tr>
                <td class="text-right"><strong>Transfer ke Rekening Program:</strong></td>
                <td class="text-right" style="width: 30%;">Rp {{ number_format($invTotalProgram, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-right"><strong>Transfer ke Rekening Transport:</strong></td>
                <td class="text-right">Rp {{ number_format($invTransportPrice, 0, ',', '.') }}</td>
            </tr>
            @else
            <tr>
                <td class="text-right"><strong>Subtotal:</strong></td>
                <td class="text-right" style="width: 30%;">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td class="text-right">TOTAL BAYAR:</td>
                <td class="text-right">Rp {{ number_format($subtotal, 0, ',', '.') }}</td>
            </tr>
        </table>

        <div style="clear: both;"></div>

        <div class="footer">
            {{-- Pesan Penting Kedatangan --}}
            <div style="margin-bottom: 20px; padding: 16px 20px; background: linear-gradient(135deg, #e8f0fe, #d0e4ff); border: 2px solid #3a7bd5; border-radius: 10px; text-align: left; color: #1a1a2e;">
                <p style="margin: 0 0 8px; font-size: 14px; font-weight: bold; color: #1a3c8f; display: flex; align-items: center; gap: 6px;">
                    📢 Informasi Penting Kedatangan
                </p>
                <p style="margin: 0; font-size: 13px; line-height: 1.7; color: #333;">
                    Kamu harus datang di <strong>Brilliant 2 atau 1 hari sebelum tanggal Start Program dimulai.</strong>
                    Dikarenakan akan ada <strong>Placement Tes Kemampuan Bahasa Inggris</strong> kamu dan akan masuk asrama sebelum tanggal program dimulai.
                </p>
                <p style="margin: 10px 0 0; font-size: 13px; line-height: 1.7; color: #555;">
                    📄 <strong>Harap cetak invoice ini dan tunjukkan di Front Office Brilliant</strong> ketika daftar ulang dan pelunasan.
                </p>
            </div>

            <p><strong>Catatan Penting:</strong></p>
            <p>1. Faktur ini sah dan diterbitkan secara elektronik tanpa tanda tangan basah.<br>
               2. Uang yang sudah dibayarkan tidak dapat dikembalikan (non-refundable).<br>
               3. Harap simpan invoice ini sebagai bukti sah pendaftaran Anda.</p>
            <p style="margin-top: 20px;"><em>Terima kasih atas kepercayaan Anda memilih Brilliant!</em></p>
            <p style="margin-top: 10px; font-size: 15px; font-weight: bold; color: #1a3c8f; font-style: italic;">
                🎉 Thank you, Welcome to Brilliant!<br>
                We Are Big Family!
            </p>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js" integrity="sha512-GsLlZN/3F2ErC5ifS5QtgpiJtWd43JWSuIgh7mbzZ8zBps+dvLusV+eNQATqgA/HdeKFVgA5v3S/cIrLF7QnIg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        function downloadPDF() {
            var element = document.getElementById('invoice-content');
            var opt = {
                margin:       [0.5, 0.5, 0.5, 0.5], // top, left, bottom, right in inches
                filename:     'Invoice_{{ $pendaftaran->trx_id }}.pdf',
                image:        { type: 'jpeg', quality: 0.98 },
                html2canvas:  { scale: 2, useCORS: true },
                jsPDF:        { unit: 'in', format: 'letter', orientation: 'portrait' }
            };
            
            // Change button text while processing
            var btn = document.getElementById('btn-download');
            var originalText = btn.innerHTML;
            btn.innerHTML = 'Memproses...';
            
            html2pdf().set(opt).from(element).save().then(function() {
                btn.innerHTML = originalText;
            });
        }

        // Membuka dialog print otomatis setelah halaman di-load jika mau
        // window.onload = function() {
        //     window.print();
        // };
    </script>
</body>
</html>

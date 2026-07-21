<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendaftaranProgramOffline;
use App\Models\PendaftaranProgramOnline;
use App\Models\PendaftaranProgramCamp;
use Carbon\Carbon;

class InvoiceController extends Controller
{
    /**
     * Menampilkan halaman cetak invoice.
     *
     * @param string $trx_id
     * @return \Illuminate\View\View
     */
    public function cetak($trx_id)
    {
        // Cari pendaftaran di Offline
        $pendaftaran = PendaftaranProgramOffline::with(['program', 'bank', 'transport', 'caterings.cateringPackage', 'laundries.laundryPackage', 'holidays.holidayPackage'])
            ->where('trx_id', $trx_id)
            ->first();
        $tipe = 'Offline';

        // Jika tidak ada di Offline, cari di Online
        if (!$pendaftaran) {
            $pendaftaran = PendaftaranProgramOnline::with(['program', 'bank'])
                ->where('trx_id', $trx_id)
                ->first();
            $tipe = 'Online';
        }

        // Jika tidak ada di Online, cari di Camp
        if (!$pendaftaran) {
            $pendaftaran = PendaftaranProgramCamp::with(['program', 'bank', 'room'])
                ->where('trx_id', $trx_id)
                ->first();
            $tipe = 'Camp';
        }

        // Jika sama sekali tidak ditemukan, kembalikan 404
        if (!$pendaftaran) {
            abort(404, 'Invoice tidak ditemukan.');
        }

        // Menyiapkan array items untuk mempermudah render di view
        $items = [];
        $codeUnik = (int) env('CODE_UNIK', '002');

        // 1. Program Utama (harga program + code unik sebagai identifikasi pembayaran unik)
        $hargaProgram = ($pendaftaran->program->harga ?? 0) + $codeUnik;
        $items[] = [
            'nama'       => 'Program ' . $tipe . ' - ' . ($pendaftaran->program->nama ?? 'Program'),
            'keterangan' => 'Biaya Pendaftaran Program (termasuk kode unik ' . $codeUnik . ')',
            'qty'        => 1,
            'harga'      => $hargaProgram,
            'total'      => $hargaProgram,
        ];

        // 2. Biaya Admin (jika ada)
        $biayaAdmin = $pendaftaran->program->biaya_admin ?? 0;
        if ($biayaAdmin > 0) {
            $items[] = [
                'nama' => 'Biaya Admin',
                'keterangan' => 'Biaya Administrasi',
                'qty' => 1,
                'harga' => $biayaAdmin,
                'total' => $biayaAdmin,
            ];
        }

        // 3. Transportasi (Khusus Offline)
        if ($tipe === 'Offline' && $pendaftaran->transport) {
            $items[] = [
                'nama' => 'Layanan Transportasi',
                'keterangan' => $pendaftaran->transport->name,
                'qty' => 1,
                'harga' => $pendaftaran->transport->price,
                'total' => $pendaftaran->transport->price,
            ];
        }

        // 4. Akomodasi (Khusus Offline)
        if ($tipe === 'Offline' && $pendaftaran->akomodasi_harga > 0) {
            $items[] = [
                'nama' => 'Akomodasi (' . $pendaftaran->akomodasi_tipe . ')',
                'keterangan' => 'Biaya Akomodasi/Asrama',
                'qty' => 1,
                'harga' => $pendaftaran->akomodasi_harga,
                'total' => $pendaftaran->akomodasi_harga,
            ];
        }

        // 5. Kamar Camp (Khusus Camp)
        if ($tipe === 'Camp' && $pendaftaran->room) {
            // Asumsi harga kamar mungkin ada atau disatukan dengan program
            // Jika ada tambahan harga kamar, bisa ditambahkan di sini. Sementara kita anggap sudah include di subtotal atau room price.
        }

        // 6. Layanan Tambahan (Catering, Laundry, Holiday - Khusus Offline jika ada relasinya)
        if ($tipe === 'Offline') {
            if ($pendaftaran->caterings) {
                foreach ($pendaftaran->caterings as $catering) {
                    $pkg = $catering->cateringPackage;
                    $items[] = [
                        'nama' => 'Catering: ' . ($pkg ? $pkg->nama_paket : 'Paket Catering'),
                        'keterangan' => 'Layanan Catering',
                        'qty' => $catering->jumlah_porsi,
                        'harga' => $pkg ? $pkg->harga : ($catering->harga / $catering->jumlah_porsi),
                        'total' => $catering->harga,
                    ];
                }
            }

            if ($pendaftaran->laundries) {
                foreach ($pendaftaran->laundries as $laundry) {
                    $pkg = $laundry->laundryPackage;
                    $items[] = [
                        'nama' => 'Laundry: ' . ($pkg ? $pkg->nama_paket : 'Paket Laundry'),
                        'keterangan' => 'Layanan Laundry',
                        'qty' => $laundry->jumlah,
                        'harga' => $pkg ? $pkg->harga : ($laundry->harga / $laundry->jumlah),
                        'total' => $laundry->harga,
                    ];
                }
            }

            if ($pendaftaran->holidays) {
                foreach ($pendaftaran->holidays as $holiday) {
                    $pkg = $holiday->holidayPackage;
                    $items[] = [
                        'nama' => 'Holiday: ' . ($pkg ? $pkg->nama_paket : 'Paket Liburan'),
                        'keterangan' => 'Layanan Holiday',
                        'qty' => $holiday->jumlah_peserta,
                        'harga' => $pkg ? $pkg->harga : ($holiday->harga / $holiday->jumlah_peserta),
                        'total' => $holiday->harga,
                    ];
                }
            }
        }

        // Hitung ulang subtotal jika perlu, atau gunakan $pendaftaran->subtotal
        $subtotal = $pendaftaran->subtotal ?? collect($items)->sum('total');
        
        // Data pelanggan
        $customer = [
            'nama' => $pendaftaran->nama_lengkap ?? $pendaftaran->nama ?? '-',
            'email' => $pendaftaran->email ?? '-',
            'no_hp' => $pendaftaran->no_hp ?? $pendaftaran->no_whatsapp ?? '-',
            'alamat' => $pendaftaran->asal_kota ?? $pendaftaran->alamat ?? '-',
        ];

        return view('invoice.cetak', compact('pendaftaran', 'tipe', 'items', 'subtotal', 'customer'));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranProgramCamp extends Model
{
    protected $table = 'pendaftaran_program_camp';

    protected $fillable = [
        'nama_lengkap',
        'email',
        'no_hp',
        'asal_kota',
        'program_camp_id',
        'period_id',
        'durasi_paket',
        'nama_kamar',
        'bukti_pembayaran',
        'status',
        'bank_id',
    ];

    // Relasi ke ProgramCamp
    public function programCamp()
    {
        return $this->belongsTo(ProgramCamp::class);
    }

    // Relasi ke Period
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    // Relasi ke Bank
    public function bank()
    {
        return $this->belongsTo(Banks::class);
    }
}

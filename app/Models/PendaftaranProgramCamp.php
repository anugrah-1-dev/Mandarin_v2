<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ProgramCamp;
use App\Models\Banks;

class PendaftaranProgramCamp extends Model
{
    use HasFactory;

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
    ];

    // Relasi ke program camp
    public function programCamp()
    {
        return $this->belongsTo(ProgramCamp::class, 'program_camp_id');
    }

    // Relasi ke periode
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    public function bank()
    {
        return $this->belongsTo(Banks::class);
    }
}

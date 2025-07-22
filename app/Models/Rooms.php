<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class rooms extends Model
{
    use HasFactory;

    protected $table = 'rooms';
    protected $fillable = [
        'program_camp_id',
        'nama',
        'nomor_kamar',
        'gender',
        'kategori',
        'kapasitas',
        'penghuni',
    ];

    /**
     * Relasi ke ProgramCamp
     */
    public function programCamp()
    {
        return $this->belongsTo(ProgramCamp::class);
    }

    /**
     * Getter: Status Kamar (optional)
     */
    // public function getStatusAttribute()
    // {
    //     if ($this->penghuni >= $this->kapasitas) {
    //         return 'penuh';
    //     } elseif ($this->penghuni == 0) {
    //         return 'kosong';
    //     } else {
    //         return 'sebagian';
    //     }
    // }
}

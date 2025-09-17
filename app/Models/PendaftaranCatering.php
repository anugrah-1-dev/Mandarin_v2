<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranCatering extends Model
{
    protected $table = 'pendaftaran_catering';

    protected $fillable = [
        'pendaftaran_id',
        'catering_package_id',
        'jumlah_porsi',
        'catatan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_id');
    }

    public function cateringPackage()
    {
        return $this->belongsTo(CateringPackage::class, 'catering_package_id');
    }
}


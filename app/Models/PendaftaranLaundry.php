<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranLaundry extends Model
{
    protected $table = 'pendaftaran_laundry';

    protected $fillable = [
        'pendaftaran_id',
        'laundry_package_id',
        'jumlah',
        'catatan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_id');
    }

    public function laundryPackage()
    {
        return $this->belongsTo(LaundryPackage::class, 'laundry_package_id');
    }
}

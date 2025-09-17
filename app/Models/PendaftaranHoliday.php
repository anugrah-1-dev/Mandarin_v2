<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendaftaranHoliday extends Model
{
    protected $table = 'pendaftaran_holiday';

    protected $fillable = [
        'pendaftaran_id',
        'holiday_package_id',
        'jumlah_peserta',
        'catatan',
    ];

    public function pendaftaran()
    {
        return $this->belongsTo(PendaftaranProgramOffline::class, 'pendaftaran_id');
    }

    public function holidayPackage()
    {
        return $this->belongsTo(HolidayPackage::class, 'holiday_package_id');
    }
}

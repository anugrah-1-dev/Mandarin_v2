<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'holiday_package_id',
        'image_path',
    ];

    // Relasi ke HolidayPackage
    public function holidayPackage()
    {
        return $this->belongsTo(HolidayPackage::class);
    }
}

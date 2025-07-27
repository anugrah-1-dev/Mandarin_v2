<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Carbon\Carbon;

class Period extends Model
{
    use SoftDeletes;

    protected $table = 'periods';

    protected $fillable = [
        'date',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'is_active' => 'boolean',
    ];

    public function getIsActiveAttribute($value)
    {
        if ($this->date < Carbon::today()) {
            return false;
        }

        return $value;
    }

    // Relasi ke pendaftaran program online
    public function pendaftaranOnline()
    {
        return $this->hasMany(PendaftaranProgramOnline::class, 'period_id');
    }

    // Relasi ke pendaftaran program offline
    public function pendaftaranOffline()
    {
        return $this->hasMany(PendaftaranProgramOffline::class, 'period_id');
    }


}

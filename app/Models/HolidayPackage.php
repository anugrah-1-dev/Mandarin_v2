<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'deskripsi',
        'fasilitas',
        'harga',
        'harga_promo',
        'minimal_orang',
        'durasi_hari',
        'gambar_cover',
        'status',
    ];

    protected $casts = [
        'fasilitas' => 'array', // otomatis decode JSON ke array
    ];

    // Relasi ke HolidayImage
    public function images()
    {
        return $this->hasMany(HolidayImage::class);
    }
}

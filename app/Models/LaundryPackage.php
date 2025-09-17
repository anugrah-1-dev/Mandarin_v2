<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LaundryPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_paket',
        'harga',
        'jenis',
        'periode',
        'status',
        'deskripsi',
        'thumbnail',
    ];
}

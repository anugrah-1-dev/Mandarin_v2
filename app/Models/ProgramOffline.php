<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProgramOffline extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'program_offline';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'slug',
        'lama_program',
        'kategori',
        'harga',
        'features_program',
        'lokasi',
        'jadwal_mulai',
        'jadwal_selesai',
        'kuota',
        'is_active',
        'thumbnail',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'jadwal_mulai' => 'date',
        'jadwal_selesai' => 'date',
        'is_active' => 'boolean',
        'features_program' => 'array', // Casting JSON ke array
    ];
}

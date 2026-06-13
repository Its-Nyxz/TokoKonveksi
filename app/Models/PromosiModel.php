<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromosiModel extends Model
{
    use HasFactory;

    protected $table = 'promosi';
    protected $primaryKey = 'id_promosi';
    protected $fillable = [
        'nama_promosi',
        'deskripsi',
        'foto',
        'is_active',
    ];
}

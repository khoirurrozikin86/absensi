<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarifPph extends Model
{
    use HasFactory;

    protected $table = 'tarif_pphs';

    protected $fillable = [
        'batas_bawah',
        'batas_atas',
        'tarif',
        'year',
    ];
}

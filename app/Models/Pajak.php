<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pajak extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

   public function status_ptkp()
    {
        return $this->belongsTo(StatusPtkp::class, 'status_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function dataPajak()
    {
        date_default_timezone_set('Asia/Jakarta');
        $bulan = request()->input('bulan') ? (int) request()->input('bulan') : (int) date('m');
        $tahun = request()->input('tahun') ? (int) request()->input('tahun') : (int) date('Y');


        return self::with(['user', 'status_ptkp'])
            ->where('bulan', $bulan)
            ->where('tahun', $tahun)
            ->orderBy('user_id', 'asc');
    }
}
